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
     * @var Department|null
     */
    protected null|Department $department = null;

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
     * Returns the description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Sets the description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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
