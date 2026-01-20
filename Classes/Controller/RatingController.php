<?php

declare(strict_types=1);

/**
 * This file is part of the "Partner Rating" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Eric Harrer <info@eric-harrer.de>, eric-harrer.de
 *          Axel Hempelt <info@fiz-soft.de>, fiz-soft.de
 */

namespace ErHaWeb\PartnerRating\Controller;

use ErHaWeb\PartnerRating\Domain\Model\Department;
use ErHaWeb\PartnerRating\Domain\Model\Rating;
use ErHaWeb\PartnerRating\Domain\Repository\DepartmentRepository;
use ErHaWeb\PartnerRating\Domain\Repository\RatingRepository;
use ErHaWeb\PartnerRating\Domain\Repository\ReasonRepository;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Mail\MailerInterface;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * The rating controller
 */
class RatingController extends ActionController
{
    public function __construct(
        private readonly PersistenceManager $persistenceManager,
        private readonly DepartmentRepository $departmentRepository,
        private readonly ReasonRepository $reasonRepository,
        private readonly RatingRepository $ratingRepository
    ) {}

    /**
     * Action: listAction
     *
     * This action handles the listing of departments.
     */
    public function listAction(): ResponseInterface
    {
        $this->view->assignMultiple([
            'settings' => $this->getSettings($this->request),
            'data' => $this->request->getAttribute('currentContentObject')->data,
            'departments' => $this->departmentRepository->findAll(),
        ]);
        return $this->htmlResponse();
    }

    private function getSettings(RequestInterface $request): array
    {
        /** @var Site|null $site */
        $site = $request->getAttribute('site');
        if (!$site instanceof Site) {
            return [];
        }

        $siteSettings = $site->getSettings();

        try {
            return $siteSettings->get('plugin')['tx_partnerrating_pi1']['settings'] ?? [];
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface) {
        }

        return [];
    }

    /**
     * Action: showAction
     *
     * This action handles the display of a department and its associated data.
     * @throws IllegalObjectTypeException
     */
    public function showAction(Department $department, null|Rating $rating = null): ResponseInterface
    {
        $assign = [];
        $settings = $this->getSettings($this->request);
        $ratingReasonMinValue = (int)($settings['ratingReasonMinValue'] ?? 0);
        $ratingMailMinValue = (int)($settings['ratingMailMinValue'] ?? 0);

        $assign['settings'] = $settings;

        // If rating exists save it
        if ($rating instanceof Rating) {
            if ($this->persistenceManager->isNewObject($rating)) {
                $this->ratingRepository->add($rating);
                $rating->setDepartment($department);
                $rating->setRatingDate(time());
                $this->persistenceManager->persistAll();

                if ($rating->getRateValue() > $ratingMailMinValue) {
                    $this->sendMail($rating, $settings);
                }
            }
            $assign['savedRating'] = $rating;
        }

        $assign['data'] = $this->request->getAttribute('currentContentObject')->data;
        $assign['ratingValues'] = array_map(intval(...), $settings['ratingValues'] ?? []);

        $assign['dataAttributes']['ratingreasonminvalue'] = $ratingReasonMinValue;
        $assign['dataAttributes']['keepminonesearchresult'] = (int)($settings['keepMinOneSearchResult'] ?? 0) !== 0 ? 1 : 0;

        $partnerLabelFields = $settings['partnerLabelFields'] ?? [];

        $existingColumns = array_keys($GLOBALS['TCA']['tx_partnerrating_domain_model_partner']['columns']);
        foreach ($partnerLabelFields as $key => $replaceColumn) {
            if (!in_array($replaceColumn, $existingColumns, true)) {
                unset($partnerLabelFields[$key]);
            }
        }

        $assign['dataAttributes']['partnerlabelfields'] = json_encode(array_values($partnerLabelFields));

        // Assign department, reasons, and partners to the view
        $assign['department'] = $department;
        $assign['reasons'] = $this->reasonRepository->findBy(['department' => $department]);

        // Process and assign filtering values to the view
        $values = [];
        $partner = $this->request->getArguments()['partner'] ?? null;
        if ($partner !== null) {
            $values['partner'] = $partner;
        }

        $partnerSearch = htmlspecialchars(($this->request->getArguments()['partnerSearch'] ?? ''), ENT_NOQUOTES | ENT_SUBSTITUTE | ENT_HTML401);
        if ($partnerSearch !== '') {
            $values['partnerSearch'] = $partnerSearch;
        }

        $reason = $this->request->getArguments()['reason'] ?? null;
        if ($reason !== null) {
            $values['reason'] = $reason;
        }

        $reasonText = $this->request->getArguments()['reasonText'] ?? '';
        if ($reasonText !== '') {
            $values['reasonText'] = htmlspecialchars((string)$reasonText);
        }

        $rating = $this->request->getArguments()['rating'] ?? null;
        if ($rating !== null) {
            $values['rating'] = $rating;
        }

        if ($values !== []) {
            $assign['values'] = $values;
        }

        $this->view->assignMultiple($assign);
        return $this->htmlResponse();
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function sendMail(Rating $rating, array $settings): void
    {
        $mailSubject = $settings['mail']['subject'] ?? '';
        $mailTo = $settings['mail']['to'] ?? '';
        $mailFrom = $settings['mail']['from'] ?? '';

        if (!$mailSubject || !$mailTo) {
            return;
        }

        $email = new FluidEmail();
        $email
            ->to($mailTo)
            ->subject($mailSubject)
            ->format(FluidEmail::FORMAT_BOTH) // send HTML and plaintext mail
            ->setTemplate('Rating')
            ->assignMultiple([
                'headline' => $mailSubject,
                'rating' => $rating,
                'dateFormat' => $settings['mail']['dateFormat'] ?? '',
            ]);
        if ($mailFrom) {
            $email->from($mailFrom);
        }
        $mailerInterface = GeneralUtility::makeInstance(MailerInterface::class);
        $mailerInterface->send($email);
    }
}
