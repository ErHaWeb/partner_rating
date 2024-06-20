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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Partner
 */
class Partner extends AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    protected string $title = '';

    /**
     * partnerNr
     *
     * @var string
     */
    protected string $partnerNr = '';

    /**
     * Returns the title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the partnerNr
     */
    public function getPartnerNr(): string
    {
        return $this->partnerNr;
    }

    /**
     * Sets the partnerNr
     */
    public function setPartnerNr(string $partnerNr): void
    {
        $this->partnerNr = $partnerNr;
    }
}
