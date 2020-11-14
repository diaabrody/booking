<?php

namespace App\Jobs;

use App\Repositories\Interfaces\Chalet\IChaletRepository;
use App\Repositories\Interfaces\UserView\IUserViewRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogChaletView implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $chalet_id;
    private $ip;
    private  $user_id;
    public function __construct($chalet_id , $ip , $user_id)
    {
        $this->chalet_id = $chalet_id;
        $this->ip = $ip;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @param IUserViewRepository $userViewRepository
     * @return void
     */
    public function handle(IUserViewRepository $userViewRepository , IChaletRepository $chaletRepository)
    {
//            $userViews= cache()->remember("userViews_{$this->chalet_id}" , 7200 , function () use ($userViewRepository){
//                  return $userViewRepository->doGuestOrUserViewChalet($this->chalet_id ,  $this->ip , $this->user_id);
//             });
            if($userViewRepository->doGuestOrUserViewChalet($this->chalet_id ,  $this->ip , $this->user_id))   return;
            $userViewRepository->insertChaletView($this->chalet_id ,  $this->ip , $this->user_id);
            $chaletRepository->incrementChaletViewsOne($this->chalet_id);
    }
}
