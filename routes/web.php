<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstallerController;
use App\Http\Controllers\PaymentController;

Route::get('/', [MainController::class, 'index']);
Route::get('/faq', [MainController::class, 'faq']);
Route::get('/tos', [MainController::class, 'tos']);
Route::get('/news', [MainController::class, 'news']);
Route::get('/imprint', [MainController::class, 'imprint']);
Route::get('/contact', [MainController::class, 'viewContact']);
Route::post('/contact', [MainController::class, 'contact']);
Route::post('/register', [MainController::class, 'register']);
Route::post('/login', [MainController::class, 'login']);
Route::any('/logout', [MainController::class, 'logout']);
Route::get('/confirm', [MainController::class, 'confirm']);
Route::get('/reset', [MainController::class, 'viewReset']);
Route::post('/recover', [MainController::class, 'recover']);
Route::get('/resend/{id}', [MainController::class, 'resend']);
Route::post('/reset', [MainController::class, 'reset']);
Route::get('/ads/code', [MainController::class, 'adCode']);
Route::get('/clep/index', [MainController::class, 'clepIndex']);

Route::get('/profiles', [MemberController::class, 'profiles']);
Route::get('/random', [MemberController::class, 'random']);
Route::any('/member/name/valid', [MemberController::class, 'nameValidity']);
Route::post('/profiles/query', [MemberController::class, 'queryProfiles']);
Route::any('/member/geo', [MemberController::class, 'saveGeoLocation']);
Route::get('/user/{ident}', [MemberController::class, 'showUser']);
Route::any('/member/like/{id}', [MemberController::class, 'likeUser']);
Route::any('/member/unlike/{id}', [MemberController::class, 'unlikeUser']);
Route::any('/member/ignore/{id}', [MemberController::class, 'ignoreUser']);
Route::any('/member/unignore/{id}', [MemberController::class, 'unignoreUser']);
Route::any('/member/report/{id}', [MemberController::class, 'reportUser']);
Route::get('/settings', [MemberController::class, 'viewSettings']);
Route::post('/member/visitors/query', [MemberController::class, 'queryVisitors']);
Route::post('/member/profile/save', [MemberController::class, 'saveProfile']);
Route::post('/member/password/save', [MemberController::class, 'savePassword']);
Route::post('/member/email/save', [MemberController::class, 'saveEmail']);
Route::post('/member/photo/save', [MemberController::class, 'savePhoto']);
Route::any('/member/photo/{which}/delete', [MemberController::class, 'deletePhoto']);
Route::post('/member/notifications/save', [MemberController::class, 'saveNotifications']);
Route::post('/member/ignores/query', [MemberController::class, 'queryIgnoreList']);
Route::post('/member/account/delete', [MemberController::class, 'deleteAccount']);
Route::post('/member/geoexclude/save', [MemberController::class, 'saveGeoExclude']);
Route::post('/member/account/verify', [MemberController::class, 'verifyAccount']);
Route::post('/member/likes/received/query', [MemberController::class, 'queryReceivedLikes']);
Route::post('/member/likes/given/query', [MemberController::class, 'queryGivenLikes']);
Route::post('/member/lookingfor/{type}/{value}', [MemberController::class, 'lookingFor']);
Route::any('/member/favorites/{id}/add', [MemberController::class, 'addFavorite']);
Route::any('/member/favorites/{id}/remove', [MemberController::class, 'removeFavorite']);
Route::post('/member/favorites/query', [MemberController::class, 'queryFavorites']);
Route::post('/member/device/token', [MemberController::class, 'setDeviceToken']);

Route::get('/messages', [MessageController::class, 'list']);
Route::get('/messages/list', [MessageController::class, 'fetchList']);
Route::get('/messages/show/{id}', [MessageController::class, 'show']);
Route::post('/messages/query', [MessageController::class, 'query']);
Route::get('/messages/create', [MessageController::class, 'create']);
Route::post('/messages/send', [MessageController::class, 'send']);
Route::any('/messages/unread/count', [MessageController::class, 'unreadCount']);

Route::get('/notifications/list', [NotificationController::class, 'list']);
Route::get('/notifications/fetch', [NotificationController::class, 'fetch']);
Route::get('/notifications/seen', [NotificationController::class, 'seen']);

Route::get('/admin', [AdminController::class, 'index']);
Route::post('/admin/about/save', [AdminController::class, 'saveAbout']);
Route::post('/admin/background/save', [AdminController::class, 'saveBackground']);
Route::post('/admin/logo/save', [AdminController::class, 'saveLogo']);
Route::post('/admin/cookieconsent/save', [AdminController::class, 'saveCookieConsent']);
Route::post('/admin/reginfo/save', [AdminController::class, 'saveRegInfo']);
Route::post('/admin/tos/save', [AdminController::class, 'saveTosContent']);
Route::post('/admin/imprint/save', [AdminController::class, 'saveImprintContent']);
Route::post('/admin/headcode/save', [AdminController::class, 'saveHeadCode']);
Route::post('/admin/adcode/save', [AdminController::class, 'saveAdCode']);
Route::get('/admin/user/details', [AdminController::class, 'userDetails']);
Route::post('/admin/user/save', [AdminController::class, 'userSave']);
Route::any('/admin/user/{id}/resetpw', [AdminController::class, 'userResetPassword']);
Route::any('/admin/user/{id}/delete', [AdminController::class, 'userDelete']);
Route::post('/admin/feature/create', [AdminController::class, 'createFeature']);
Route::post('/admin/feature/edit', [AdminController::class, 'editFeature']);
Route::any('/admin/feature/{id}/remove', [AdminController::class, 'removeFeature']);
Route::post('/admin/faq/create', [AdminController::class, 'createFaq']);
Route::post('/admin/faq/edit', [AdminController::class, 'editFaq']);
Route::any('/admin/faq/{id}/remove', [AdminController::class, 'removeFaq']);
Route::any('/admin/user/{id}/lock', [AdminController::class, 'lockUser']);
Route::any('/admin/user/{id}/safe', [AdminController::class, 'setUserSafe']);
Route::post('/admin/newsletter', [AdminController::class, 'newsletter']);
Route::any('/admin/verify/{id}/approve', [AdminController::class, 'approveAccount']);
Route::any('/admin/verify/{id}/decline', [AdminController::class, 'declineAccount']);
Route::any('/admin/approval/photo/{userId}/{which}/approve', [AdminController::class, 'approvePhoto']);
Route::any('/admin/approval/photo/{userId}/{which}/decline', [AdminController::class, 'declinePhoto']);

Route::any('/cronjob/newsletter/{password}', [MainController::class, 'cronjob_newsletter']);

Route::post('/payment/charge', [PaymentController::class, 'charge']);

Route::get('/install', [InstallerController::class, 'viewInstall']);
Route::post('/install', [InstallerController::class, 'install']);