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

namespace ErHaWeb\PartnerRating\Domain\Model;


use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

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
     * @var ?Partner
     */
    protected ?Partner $partner = null;

    /**
     * reason
     *
     * @var ?Reason
     */
    protected ?Reason $reason = null;

    /**
     * reasonText
     *
     * @var string
     */
    protected string $reasonText = '';

    /**
     * department
     *
     * @var ?Department
     */
    protected ?Department $department = null;

    /**
     * Returns the rateValue
     *
     * @return int
     */
    public function getRateValue(): int
    {
        return $this->rateValue;
    }

    /**
     * Sets the rateValue
     *
     * @param int $rateValue
     * @return void
     */
    public function setRateValue(int $rateValue): void
    {
        $this->rateValue = $rateValue;
    }

    /**
     * Returns the partner
     *
     * @return ?Partner
     */
    public function getPartner(): ?Partner
    {
        return $this->partner;
    }

    /**
     * Sets the partner
     *
     * @param Partner $partner
     * @return void
     */
    public function setPartner(Partner $partner): void
    {
        $this->partner = $partner;
    }

    /**
     * Returns the reason
     *
     * @return ?Reason
     */
    public function getReason(): ?Reason
    {
        return $this->reason;
    }

    /**
     * Sets the reason
     *
     * @param Reason $reason
     * @return void
     */
    public function setReason(Reason $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * Returns the reasonText
     *
     * @return string
     */
    public function getReasonText(): string
    {
        return $this->reasonText;
    }

    /**
     * Sets the reasonText
     *
     * @param string $reasonText reasonText
     * @return void
     */
    public function setReasonText(string $reasonText): void
    {
        $this->reasonText = $reasonText;
    }

    /**
     * Returns the department
     *
     * @return ?Department
     */
    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    /**
     * Sets the department
     *
     * @param Department $department
     * @return void
     */
    public function setDepartment(Department $department): void
    {
        $this->department = $department;
    }
}
