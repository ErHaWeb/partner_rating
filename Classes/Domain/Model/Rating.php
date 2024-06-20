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

namespace ErHaWeb\PartnerRating\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Rating
 */
class Rating extends AbstractEntity
{
    /**
     * rateValue
     *
     * @var int
     */
    protected int $rateValue = 0;

    /**
     * partner
     *
     * @var null|Partner
     */
    protected null|Partner $partner = null;

    /**
     * reason
     *
     * @var null|ObjectStorage<Reason>
     */
    #[Cascade(['value' => 'remove'])]
    protected null|ObjectStorage $reason = null;

    /**
     * reasonText
     *
     * @var string
     */
    protected string $reasonText = '';

    /**
     * department
     *
     * @var null|Department
     */
    protected null|Department $department = null;

    /**
     * __construct
     */
    public function __construct()
    {

        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     */
    public function initializeObject(): void
    {
        $this->reason = $this->reason ?: new ObjectStorage();
    }

    /**
     * Returns the rateValue
     */
    public function getRateValue(): int
    {
        return $this->rateValue;
    }

    /**
     * Sets the rateValue
     */
    public function setRateValue(int $rateValue): void
    {
        $this->rateValue = $rateValue;
    }

    /**
     * Returns the partner
     */
    public function getPartner(): null|Partner
    {
        return $this->partner;
    }

    /**
     * Sets the partner
     */
    public function setPartner(Partner $partner): void
    {
        $this->partner = $partner;
    }

    /**
     * Adds a Reason
     */
    public function addReason(Reason $reason): void
    {
        $this->reason->attach($reason);
    }

    /**
     * Removes a Reason
     */
    public function removeReason(Reason $reasonToRemove): void
    {
        $this->reason->detach($reasonToRemove);
    }

    /**
     * Returns the reason
     * @return null|ObjectStorage<Reason>
     */
    public function getReason(): null|ObjectStorage
    {
        return $this->reason;
    }

    /**
     * Sets the reason
     * @param ObjectStorage<Reason> $reason
     */
    public function setReason(ObjectStorage $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * Returns the reasonText
     */
    public function getReasonText(): string
    {
        return $this->reasonText;
    }

    /**
     * Sets the reasonText
     */
    public function setReasonText(string $reasonText): void
    {
        $this->reasonText = $reasonText;
    }

    /**
     * Returns the department
     */
    public function getDepartment(): null|Department
    {
        return $this->department;
    }

    /**
     * Sets the department
     */
    public function setDepartment(Department $department): void
    {
        $this->department = $department;
    }
}
