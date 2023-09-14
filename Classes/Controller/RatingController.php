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

        // Assign department, reasons, and partners to the view
        $assign['department'] = $department;
        $assign['reasons'] = $this->reasonRepository->findBy(['department' => $department]);
        $assign['partners'] = $this->partnerRepository->findAll();

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
            $this->view->assign('values', $values);
        }

        $assign['values'] = $values;

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
     * @throws IllegalObjectTypeException
     */
    public function saveAction(?Department $department, ?Partner $partner): ResponseInterface
    {
        $reason = (int)($this->request->getArguments()['reason'] ?? 0);
        $rating = (int)($this->request->getArguments()['rating'] ?? 0);
        $reasonText = htmlspecialchars($this->request->getArguments()['reasonText'] ?? '');

        // Check if required data is available, if not, redirect
        if ($department === null || $partner === null || ($reason === -1 && $reasonText === '') || ($reason === 0 && $rating > 3)) {
            return $this->redirect('show', 'Rating', 'PartnerRating', $this->request->getArguments());
        }

        // Create a new Rating object and set its properties
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