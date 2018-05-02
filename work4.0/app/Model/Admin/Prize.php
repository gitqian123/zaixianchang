<?php

namespace App\Model\Admin;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $table = 'huyu_prize';
    /**
     * 指定主键。
     */
    protected $primaryKey = 'id';
    /**
     * 指定是否模型应该被戳记时间。
     */
    public $timestamps = false;

    public static function PrizeAll($admin)
    {
      return  self::select('id','prize_name','prize_img','prize_grouping','prize_time','prize_status')->where('prize_adminer',$admin)->get();
    }
    public static function PrizeDel($admin,$id)
    {
        return  self::where('prize_adminer',$admin)->where('id',$id)->delete();
    }
    public static function PrizeFirst($admin,$id)
    {
        return  self::select('id','prize_name','prize_img','prize_grouping','prize_time','prize_status')->where("id",$id)->where('prize_adminer',$admin)->first();
    }
    public static function PrizeIdNameImg($admin,$id)
    {
        return  self::select('id','prize_name','prize_img')->where("id",$id)->where('prize_adminer',$admin)->first();
    }
    //获取奖品id name
    public  static function PrizeIdName($admin)
    {
        return  self::select('id','prize_name')->where("prize_status",1)->where('prize_adminer',$admin)->get();
    }

    /**
     *  Wall大屏幕
    **/
    public static function Prize($admin)
    {
        return self::select("id","prize_name","prize_img")->where("prize_status",1)->where("prize_adminer",$admin)->get()->toArray();
    }
    public  static function PrizeNameImg($admin)
    {
        return  self::select('prize_name','prize_img')->where("prize_status",1)->where('prize_adminer',$admin)->get()->toArray();
    }

}
