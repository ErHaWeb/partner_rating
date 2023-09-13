<?php

declare(strict_types=1);

namespace ErHaWeb\PartnerRating\Domain\Model;


use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * This file is part of the "Partner-Rating" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 
 */

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
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the partnerNr
     *
     * @return string
     */
    public function getPartnerNr(): string
    {
        return $this->partnerNr;
    }

    /**
     * Sets the partnerNr
     *
     * @param string $partnerNr
     * @return void
     */
    public function setPartnerNr(string $partnerNr): void
    {
        $this->partnerNr = $partnerNr;
    }
}
