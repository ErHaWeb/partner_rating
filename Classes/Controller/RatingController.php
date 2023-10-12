<?php

declare(strict_types=1);

/**
 * This file is part of the "Partner Rating" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 Eric Harrer <info@eric-harrer.de>, eric-harrer.de
 *          Axel Hempelt <info@fiz-soft.de>, fiz-soft.de
 */

namespace ErHaWeb\PartnerRating\Controller;


use ErHaWeb\PartnerRating\Domain\Model\Department;
use ErHaWeb\PartnerRating\Domain\Model\Partner;
use ErHaWeb\PartnerRating\Domain\Model\Rating;
use ErHaWeb\PartnerRating\Domain\Model\Reason;
use ErHaWeb\PartnerRating\Domain\Repository\DepartmentRepository;
use ErHaWeb\PartnerRating\Domain\Repository\PartnerRepository;
use ErHaWeb\PartnerRating\Domain\Repository\RatingRepository;
use ErHaWeb\PartnerRating\Domain\Repository\ReasonRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * The rating controller
 */
class RatingController extends ActionController
{
    private PersistenceManager $persistenceManager;
    private DepartmentRepository $departmentRepository;
    private ReasonRepository $reasonRepository;
    private PartnerRepository $partnerRepository;
    private RatingRepository $ratingRepository;

    public function __construct(
        PersistenceManager   $persistenceManager,
        DepartmentRepository $departmentRepository,
        ReasonRepository     $reasonRepository,
        PartnerRepository    $partnerRepository,
        RatingRepository     $ratingRepository
    )
    {
        $this->ratingRepository = $ratingRepository;
        $this->partnerRepository = $partnerRepository;
        $this->reasonRepository = $reasonRepository;
        $this->departmentRepository = $departmentRepository;
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * Action: listAction
     *
     * This action handles the listing of departments.
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        // Load all departments and assign them to the view
        $this->view->assign('departments', $this->departmentRepository->findAll());
        return $this->htmlResponse();
    }

    /**
     * Action: showAction
     *
     * This action handles the display of a department and its associated data.
     *
     * @param Department $department The department to display
     * @param Rating|null $savedRating An optional saved rating for display
     * @return ResponseInterface
     */
    public function showAction(Department $department, ?Rating $savedRating = null): ResponseInterface
    {
        $assign = [];
        $assign['data'] = $this->configurationManager->getContentObject()->data;
        $assign['ratingValues'] = GeneralUtility::intExplode(',', $this->settings['ratingValues']);

        $assign['ratingReasonMinValue'] = (int)$this->settings['ratingReasonMinValue'];
        $assign['keepMinOneSearchResult'] = (int)$this->settings['keepMinOneSearchResult'] ? 1 : 0;

        $partnerLabelFields = GeneralUtility::trimExplode(',', $this->settings['partnerLabelFields']);
        $existingColumns = array_keys($GLOBALS['TCA']['tx_partnerrating_domain_model_partner']['columns']);
        foreach ($partnerLabelFields as $key => $replaceColumn) {
            if (!in_array($replaceColumn, $existingColumns, true)) {
                unset($partnerLabelFields[$key]);
            }
        }

        $assign['partnerLabelFields'] = implode(',', $partnerLabelFields);

        // Assign department, reasons, and partners to the view
        $assign['department'] = $department;
        $assign['reasons'] = $this->reasonRepository->findByDepartment($department);

        if ($savedRating !== null) {
            $assign['savedRating'] = $savedRating;
        }

        // Process and assign filtering values to the view
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
            $assign['values'] = $values;
        }

        $this->view->assignMultiple($assign);
        return $this->htmlResponse();
    }

    /**
     * Action: saveAction
     *
     * This action handles the saving of a rating.
     *
     * @param Department|null $department The department associated with the rating
     * @param Partner|null $partner The partner associated with the rating
     * @return ResponseInterface
     * @throws IllegalObjectTypeException|StopActionException
     */
    public function saveAction(?Department $department, ?Partner $partner): ResponseInterface
    {
        $reason = (int)($this->request->getArguments()['reason'] ?? 0);
        $rating = (int)($this->request->getArguments()['rating'] ?? 0);
        $reasonText = htmlspecialchars($this->request->getArguments()['reasonText'] ?? '');
        $ratingReasonMinValue = (int)$this->settings['ratingReasonMinValue'];

        // Check if required data is available, if not, redirect
        if ($department === null || $partner === null || ($reason === -1 && $reasonText === '') || ($reason === 0 && $ratingReasonMinValue !== 0 && $rating > $ratingReasonMinValue)) {
            return $this->redirect('show', 'Rating', 'PartnerRating', $this->request->getArguments());
        }

        // Create a new Rating object and set its properties
        /** @var Reason $reasonObject */
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

        // Add the rating to the repository and persist it
        $this->ratingRepository->add($ratingObject);
        $this->persistenceManager->persistAll();

        // Redirect to the "show" action with appropriate arguments
        return $this->redirect('show', 'Rating', 'PartnerRating', ['department' => $department->getUid(), 'savedRating' => $ratingObject]);
    }
}