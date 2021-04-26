<?php

/**
 * @OA\Schema(
 *     schema="Pagination",
 *     type="object",
 *     description="The metadata response of pagination.",
 *     @OA\Property(
 *         property="total",
 *         description="The number of rows",
 *         format="int32",
 *         type="integer"
 *     ),
 *     @OA\Property(
 *         property="count",
 *         description="The number of rows on the current page",
 *         format="int32",
 *         type="integer"
 *     ),
 *     @OA\Property(
 *         property="per_page",
 *         description="The quantity of rows per page",
 *         format="int32",
 *         type="integer"
 *     ),
 *     @OA\Property(
 *         property="current_page",
 *         description="The current page",
 *         format="int32",
 *         type="integer"
 *     ),
 *     @OA\Property(
 *         property="total_pages",
 *         description="The number of pages",
 *         format="int32",
 *         type="integer"
 *     ),
 *     @OA\Property(
 *         property="links",
 *         description="Links to paginate",
 *         type="array",
 *         @OA\Items()
 *     ),
 *     example={
 *         "total": 1,
 *         "count": 1,
 *         "per_page": 50,
 *         "current_page": 1,
 *         "total_pages": 1,
 *         "links": {}
 *     }
 * )
 */
