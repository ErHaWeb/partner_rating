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
use Psr\Http\Message\ResponseInterface;
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
        $assign['data'] = $this->request->getAttribute('currentContentObject')->data;
        $assign['departments'] = $this->departmentRepository->findAll();
        $this->view->assignMultiple($assign);
        return $this->htmlResponse();
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

        // If rating exists save it
        if ($rating !== null) {
            if ($this->persistenceManager->isNewObject($rating)) {
                $this->ratingRepository->add($rating);
                $rating->setDepartment($department);
                $this->persistenceManager->persistAll();
            }
            $assign['savedRating'] = $rating;
        }

        $assign['data'] = $this->request->getAttribute('currentContentObject')->data;
        $assign['ratingValues'] = GeneralUtility::intExplode(',', ($this->settings['ratingValues'] ?? ''));

        $assign['dataAttributes']['ratingreasonminvalue'] = (int)($this->settings['ratingReasonMinValue'] ?? 0);
        $assign['dataAttributes']['keepminonesearchresult'] = (int)($this->settings['keepMinOneSearchResult'] ?? 0) ? 1 : 0;

        $partnerLabelFields = GeneralUtility::trimExplode(',', ($this->settings['partnerLabelFields'] ?? ''));
        $existingColumns = array_keys($GLOBALS['TCA']['tx_partnerrating_domain_model_partner']['columns']);
        foreach ($partnerLabelFields as $key => $replaceColumn) {
            if (!in_array($replaceColumn, $existingColumns, true)) {
                unset($partnerLabelFields[$key]);
            }
        }

        $assign['dataAttributes']['partnerlabelfields'] = implode(',', $partnerLabelFields);
        $assign['dataAttributes']['partnerlabelfieldsplitstring'] = $this->settings['partnerLabelFieldSplitString'] ?? '|';

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
            $values['reasonText'] = htmlspecialchars($reasonText);
        }

        $rating = $this->request->getArguments()['rating'] ?? null;
        if ($rating !== null) {
            $values['rating'] = $rating;
        }

        if (!empty($values)) {
            $assign['values'] = $values;
        }

        $this->view->assignMultiple($assign);
        return $this->htmlResponse();
    }
}
