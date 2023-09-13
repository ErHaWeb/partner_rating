<?php

declare(strict_types=1);

namespace ErHaWeb\PartnerRating\Controller;


use ErHaWeb\PartnerRating\Domain\Model\Department;
use ErHaWeb\PartnerRating\Domain\Model\Partner;
use ErHaWeb\PartnerRating\Domain\Model\Rating;
use ErHaWeb\PartnerRating\Domain\Repository\DepartmentRepository;
use ErHaWeb\PartnerRating\Domain\Repository\PartnerRepository;
use ErHaWeb\PartnerRating\Domain\Repository\RatingRepository;
use ErHaWeb\PartnerRating\Domain\Repository\ReasonRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * This file is part of the "Partner-Rating" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023
 */

/**
 * The rating controller
 */
class RatingController extends ActionController
{
    public function __construct(
        private readonly PersistenceManager   $persistenceManager,
        private readonly DepartmentRepository $departmentRepository,
        private readonly ReasonRepository     $reasonRepository,
        private readonly PartnerRepository    $partnerRepository,
        private readonly RatingRepository     $ratingRepository
    )
    {
    }

    /**
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $this->view->assign('departments', $this->departmentRepository->findAll());
        return $this->htmlResponse();
    }

    /**
     * @param Department $department
     * @param Rating|null $savedRating
     * @return ResponseInterface
     */
    public function showAction(Department $department, ?Rating $savedRating = null): ResponseInterface
    {
        $assign = [];

        $assign['department'] = $department;
        $assign['reasons'] = $this->reasonRepository->findBy(['department' => $department]);
        $assign['partners'] = $this->partnerRepository->findAll();

        if ($savedRating !== null) {
            $assign['savedRating'] = $savedRating;
        }

        $values = [];
        $partner = (int)($this->request->getArguments()['partner'] ?? 0);
        if ($partner !== 0) {
            $values['partner'] = $partner;
        }

        $partnerSearch = htmlspecialchars($this->request->getArguments()['partnerSearch'] ?? '', ENT_NOQUOTES | ENT_SUBSTITUTE | ENT_HTML401);
        if ($partnerSearch !== '') {
            $values['partnerSearch'] = $partnerSearch;
        }

        $reason = (int)($this->request->getArguments()['reason'] ?? 0);
        if ($reason !== 0) {
            $values['reason'] = $reason;
        }

        $reasonText = htmlspecialchars($this->request->getArguments()['reasonText'] ?? '');
        if ($reasonText !== '') {
            $values['reasonText'] = $reasonText;
        }

        $rating = (int)($this->request->getArguments()['rating'] ?? 0);
        if ($rating !== 0) {
            $values['rating'] = $rating;
        }

        if (!empty($values)) {
            $this->view->assign('values', $values);
        }

        $assign['values'] = $values;

        $this->view->assignMultiple($assign);
        return $this->htmlResponse();
    }

    /**
     * @param Department|null $department
     * @param Partner|null $partner
     * @return ResponseInterface
     * @throws IllegalObjectTypeException
     */
    public function saveAction(?Department $department, ?Partner $partner): ResponseInterface
    {
        $reason = (int)($this->request->getArguments()['reason'] ?? 0);
        $rating = (int)($this->request->getArguments()['rating'] ?? 0);
        $reasonText = htmlspecialchars($this->request->getArguments()['reasonText'] ?? '');

        if ($department === null || $partner === null || ($reason === -1 && $reasonText === '') || ($reason === 0 && $rating > 3)) {
            return $this->redirect('show', 'Rating', 'PartnerRating', $this->request->getArguments());
        }

        $reasonObject = $this->reasonRepository->findByUid($reason);

        /** @var Rating $ratingObject */
        $ratingObject = GeneralUtility::makeInstance(Rating::class);
        $ratingObject->setDepartment($department);
        $ratingObject->setPartner($partner);
        if (!is_null($reasonObject)) {
            $ratingObject->setReason($reasonObject);
        } else {
            $ratingObject->setReasonText($reasonText);
        }
        $ratingObject->setRateValue($rating);
        $this->ratingRepository->add($ratingObject);
        $this->persistenceManager->persistAll();

        return $this->redirect('show', 'Rating', 'PartnerRating', ['department' => $department->getUid(), 'savedRating' => $ratingObject]);
    }
}