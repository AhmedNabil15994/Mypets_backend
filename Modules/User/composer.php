<?php





view()->composer([
    "apps::frontend.layouts._header"

    ], \Modules\User\ViewComposers\Frontend\FavoriteComposer::class);



view()->composer([
    "apps::frontend.layouts._footer"

    ], \Modules\User\ViewComposers\Frontend\UserComposer::class);
