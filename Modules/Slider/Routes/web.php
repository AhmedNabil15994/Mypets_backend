<?php


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth','permission:dashboard_access'])->group(function () {

    foreach (File::allFiles(module_path('Slider', 'Routes/Dashboard')) as $file) {
        require_once($file->getPathname());
    }

});

// /*
// |================================================================================
// |                             FRONT-END ROUTES
// |================================================================================
// */
// Route::prefix('/')->group(function () {
//
//     foreach (File::allFiles(module_path('Slider', 'Routes/FrontEnd')) as $file) {
//         require_once($file->getPathname());
//     }
//
// });
