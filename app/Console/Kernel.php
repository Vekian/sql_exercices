<?php

namespace App\Console;

use App\Console\Commands\Alerte\AppListSeekerByOfferDept;
use App\Console\Commands\Alerte\AppListSeekerByOfferRegion;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use App\Console\Commands\AppInstall;
use App\Console\Commands\Dates\AppListAdsByDate;
use App\Console\Commands\Distance\AppListCitiesByLat;
use App\Console\Commands\Dates\AppListTitleAdByDayCreated;
use App\Console\Commands\Dates\AppListTitleAdCreated;
use App\Console\Commands\Dates\AppListTitleAdCreatedFrench;
use App\Console\Commands\Dates\AppListUsersMonth;
use App\Console\Commands\Distance\AppListCitiesByLatAll;
use App\Console\Commands\Localisation\AppCountAnnonceCity;
use App\Console\Commands\Localisation\AppCountAnnonceDept;
use App\Console\Commands\Localisation\AppCountAnnonceRegion;
use App\Console\Commands\Procedures\AppCreateAdByProc;
use App\Console\Commands\Procedures\AppEditAdHistory;
use App\Console\Commands\Procedures\AppListCitiesByProc;
use App\Console\Commands\Simples\AppFirstDocUser;
use App\Console\Commands\Simples\AppListDocUser;
use App\Console\Commands\Simples\AppListProdAnnonce;
use App\Console\Commands\Simples\AppListProdName;
use App\Console\Commands\Simples\AppListUsersCp;
use App\Console\Commands\Simples\AppListUsersDept;
use App\Console\Commands\Transaction\AppCreateAnnonce;
use App\Console\Commands\Transaction\AppDeleteAnnonce;
use App\Console\Commands\Types\AppListAnnonceByOffer;
use App\Console\Commands\Types\AppListAnnonceBySeek;
use App\Console\Commands\Views\AppListAdsView;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AppInstall::class,
        AppListUsersCp::class,
        AppListUsersDept::class,
        AppListProdAnnonce::class,
        AppListProdName::class,
        AppListDocUser::class,
        AppFirstDocUser::class,
        AppCountAnnonceRegion::class,
        AppCountAnnonceDept::class,
        AppCountAnnonceCity::class,
        AppListAnnonceByOffer::class,
        AppListAnnonceBySeek::class,
        AppListSeekerByOfferRegion::class,
        AppListSeekerByOfferDept::class,
        AppListCitiesByLatAll::class,
        AppListCitiesByLat::class,
        AppCreateAnnonce::class,
        AppDeleteAnnonce::class,
        AppListUsersMonth::class,
        AppListAdsByDate::class,
        AppListTitleAdCreated::class,
        AppListTitleAdCreatedFrench::class,
        AppListTitleAdByDayCreated::class,
        AppListCitiesByProc::class,
        AppCreateAdByProc::class,
        AppEditAdHistory::class,
        AppListAdsView::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
