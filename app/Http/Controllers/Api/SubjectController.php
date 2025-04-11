<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class SubjectController extends BaseController
{
    /**
     * Display a paginated list of subjects.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Ambil data subjects dengan pagination
            $subjects = Subject::paginate(10);

            if ($subjects->isEmpty()) {
                return $this->sendResponse([], 'No subjects found.');
            }

            return $this->sendResponse($subjects, 'Subjects retrieved successfully.');
        } catch (QueryException $e) {
            return $this->sendError(
                'Failed to fetch subjects.',
                ['error' => $e->getMessage()],
                500
            );
        }
    }
}
