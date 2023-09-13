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
 * Reason
 */
class Reason extends AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected string $title = '';

    /**
     * description
     *
     * @var string
     */
    protected string $description = '';

    /**
     * department
     *
     * @var ?Department
     */
    protected ?Department $department = null;

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
     * Returns the description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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
