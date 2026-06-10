<?php

namespace Webkul\Admin\Http\Controllers\Marketing\Communications;

use Webkul\Admin\DataGrids\Marketing\Communications\EnquiriesDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Marketing\Repositories\FormSubmissionRepository;

class EnquiryController extends Controller
{
    public function __construct(protected FormSubmissionRepository $formSubmissionRepository) {}

    public function index()
    {
        if (request()->ajax()) {
            return datagrid(EnquiriesDataGrid::class)->process();
        }

        return view('admin::marketing.communications.enquiries.index');
    }

    public function destroy(int $id)
    {
        try {
            $this->formSubmissionRepository->findOrFail($id)->delete();

            return response()->json([
                'message' => 'Submission deleted successfully.',
            ]);
        } catch (\Exception $e) {
            report($e);
        }

        return response()->json([
            'message' => 'Failed to delete submission.',
        ], 500);
    }
}
