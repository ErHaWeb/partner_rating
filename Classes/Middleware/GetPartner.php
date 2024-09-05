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

namespace ErHaWeb\PartnerRating\Middleware;

use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Middleware for getting partners based on search criteria.
 */
final class GetPartner implements MiddlewareInterface
{
    /**
     * Constructor for GetPartner middleware.
     */
    public function __construct(
        private readonly ConnectionPool $connectionPool
    ) {}

    /**
     * Process the HTTP request and return a JSON response of partners based on search criteria.
     * @throws Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Check if the request contains a 'searchText' parameter, if not, pass the request to the next middleware.
        if (!isset($request->getParsedBody()['searchText'])) {
            return $handler->handle($request);
        }

        // Create a JSON response with appropriate headers and body.
        return new JsonResponse($this->getPartners($request), 200);
    }

    /**
     * Retrieve a list of partners based on search criteria.
     * @throws Exception
     */
    private function getPartners(ServerRequestInterface $request): array
    {
        // Extract the search text from the request's parsed body, defaulting to an empty string if not provided.
        $searchText = htmlspecialchars($request->getParsedBody()['searchText'] ?? '', ENT_NOQUOTES | ENT_SUBSTITUTE | ENT_HTML401);
        $partnerLabelFields = GeneralUtility::trimExplode(',', $request->getParsedBody()['partnerLabelFields'] ?? [], true);

        // Retrieve the language associated with the request, falling back to the default language of the site.
        /** @var SiteLanguage $language */
        $siteLanguage = $request->getAttribute('language') ?? $request->getAttribute('site')->getDefaultLanguage();
        $languageId = $siteLanguage->getLanguageId();

        // Get a query builder for the 'tx_partnerrating_domain_model_partner' table.
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tx_partnerrating_domain_model_partner');

        // Define the columns to select in the SQL query.
        $select = array_merge(['uid'], $partnerLabelFields);
        $queryBuilder->select(...$select)
            ->from('tx_partnerrating_domain_model_partner')
            ->executeQuery();

        // Create an array of WHERE clause expressions to filter results by language and search keywords.
        $whereExpressions = [
            $queryBuilder->expr()->eq('sys_language_uid', $queryBuilder->createNamedParameter($languageId, Connection::PARAM_INT)),
        ];

        // Split the search text into individual words and build expressions for each word.
        $pattern = '/("(?:[^"]|"")*"|[^"\s]+)/';
        preg_match_all($pattern, $searchText, $matches);

        $words = $matches[0];
        foreach ($words as $word) {
            // Check if the word is enclosed in double quotes.
            $isQuoted = preg_match('/^"(.+)"$/', $word, $matches);

            // Process the word and perform a search with '%' wildcards.
            $exactWord = $isQuoted ? str_replace('""', '"', $matches[1]) : $word;

            $titleExpression = $queryBuilder->expr()->like(
                'title',
                $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($exactWord) . '%')
            );
            $partnerNrExpression = $queryBuilder->expr()->like(
                'partner_nr',
                $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($exactWord) . '%')
            );

            // Combine title and partnerNr expressions with an OR condition.
            $whereExpressions[] = $queryBuilder->expr()->or($titleExpression, $partnerNrExpression);
        }

        // Apply the WHERE clause to the query builder.
        $queryBuilder->where(...$whereExpressions);

        // Execute the query and retrieve the results.
        try {
            return $queryBuilder->executeQuery()->fetchAllAssociative();
        } catch (Exception) {
        }
        return [];
    }
}
