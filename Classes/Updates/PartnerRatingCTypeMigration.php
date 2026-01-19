<?php

declare(strict_types=1);

namespace ErHaWeb\PartnerRating\Updates;

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;

#[UpgradeWizard('partnerRatingCTypeMigration')]
final class PartnerRatingCTypeMigration extends AbstractListTypeToCTypeUpdate
{
    public function getTitle(): string
    {
        return 'Migrate "Partner Rating" plugins to dedicated content elements.';
    }

    public function getDescription(): string
    {
        return 'The "Partner Rating" plugins are now registered as content element. Update migrates existing records and backend user permissions.';
    }

    /**
     * Return array containing the "list_type" to "CType" mapping
     *
     * @return array<string, string>
     */
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'partnerrating_pi1' => 'partnerrating_pi1',
        ];
    }
}
