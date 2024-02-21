<?php

Route::get("/active-user", function () {
    return auth()->user();
});
