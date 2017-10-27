<?php
namespace app\modules\shop\models;
use common\models\Admin;
use common\models\BanquetOrder;
use common\models\Commission;
use common\models\Region;
use common\models\Shop;
use common\models\ShopAccount;
use common\models\ShopBanquet;
use common\models\ShopRecord;
use common\models\ShopUser;
use common\models\UserOrder;
use common\web\Upload;
use yii\base\Exception;
use yii\base\Model;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/19
 * Time: 11:07
 */
class ShopDo extends Model
{
    public static function ShopList($post=null){
        $query=new Query();
        $query->select([
            's.*',
            'a.user_name'
        ]);
        $query->from([
            's' => Shop::tableName()
        ]);
        $query->leftJoin([
            'a' => Admin::tableName()
        ], 's.operator_id = a.user_id');
        //商铺名字
        if(!empty($post['shop_name']))
        {
            $query->andWhere([
                'like',
                's.shop_name',
                $post['shop_name']
            ]);
        }
        //店铺状态
        if(!empty($post['shop_status']))
        {
            $shop_status=$post['shop_status']-1;
            $query->andWhere([
                's.shop_status' => $shop_status
            ]);
        }
        //创建时间
        if(!empty($post['create_time_start']))
        {
            $create_time_start=strtotime($post['create_time_start']);
            $query->andwhere('s.create_time >= :create_time_begin', [
                ':create_time_begin' => $create_time_start
            ]);
        }
        if(!empty($post['create_time_end']))
        {
            $create_time_end=strtotime($post['create_time_end']);
            $query->andwhere('s.create_time <= :create_time_end', [
                ':create_time_end' => $create_time_end
            ]);
        }
        //地区检索
        if(!empty($post['region_code']))
        {
            $query->andWhere("s.region_code like :region_code", [
                ':region_code' => $post['region_code'] . '%'
            ]);
        }
        $data=$query->all();
        $data=fenye($data);
        return $data;
    }
    public static function ShopInfo($id='')
    {
        $query=new Query();
        $query->select([
            's.*',
            'sa.*'
        ]);

        $query->from([
            's' => Shop::tableName()
        ]);
        $query->leftJoin([
            'sa' =>ShopAccount::tableName()
        ], 's.shop_id = sa.shop_id');
        $query->andWhere([
            's.shop_id' => $id
        ]);
        $data=$query->one();
        //流水席数 banquet_status=1->流水席的启用状态
        $data['banquets']=ShopBanquet::find()->where(['shop_id' => $id])->count('banquet_id');
        //成交订单
        $query = new Query();
        $query->from(BanquetOrder::tableName().'bo');
        //ps bo.order_status =3代表席单状态为已完成
        $query->where(['bo.order_status' =>3]);
        $query->andWhere(['bo.shop_id' =>$id]);
        //成交的全部成功订单数量
        $data['banquet_orders']=$query->count();
//        $data['banquet_orders']=BanquetOrder::find()->where('shop_id='.$id.' and order_status=3')->count('order_id');
//        //销售总额
        $query = new Query();
        $query->from(UserOrder::tableName().'uo');
        $query->where(['uo.order_status' =>3]);
        $query->andWhere(['uo.shop_id' =>$id]);
        $data['sales_amount'] = $query->sum('uo.pay_amount+uo.pay_meal_ticket');

//        $data['sales_amount']=UserOrder::find()->where('shop_id='.$id.' and order_status=3')->sum('pay_amount');
//        $data['sales_amount']=$data['sales_amount']+UserOrder::find()->where('shop_id='.$id.' and order_status=3')->sum('pay_meal_ticket');
//        //结算总额
        $withdraw_amount = ShopRecord::find()->select('sum(request_amount) as request_amount')->where('shop_id='.$id.' and request_status=1')->one();
        $data['withdraw_amount']=$withdraw_amount->request_amount;
        if (empty($data['withdraw_amount'])) {
            $data['withdraw_amount']=0;
        }
//        //余额
//        $data['total_balnce']=$data['sales_amount']-$data['withdraw_amount'];
//        $amount= ShopRecord::find()->where('shop_id='.$id.' and request_status=0')->sum('request_amount');
//        $data['total_balnce']=$data['total_balnce']-$amount;
//        //分佣总额
//        $data['platform_amount']=BanquetOrder::find()->where('shop_id='.$id.' and order_status=3')->sum('commission_amount');
        //商家用户数
        $total_user=UserOrder::find()->select('*')->where(['shop_id' =>$id ,'order_status' => 3])->groupBy('user_id')->asArray()->all();
        $data['total_user']= count($total_user);
       //分佣比例
       $commission_rate=Commission::find()->select('commission_rate')->where('shop_id='.$id)->asArray()->one();
       $data['commission_rate']=$commission_rate['commission_rate'];
       return $data;

    }
    public static function ShopAdd($post=null)
    {
        $model=new Shop();
        $model->shop_name=$post['shop_name'];
        $model->merchant_name=$post['merchant_name'];
        $model->merchant_mobile=$post['merchant_mobile'];
        $model->merchant_area=$post['merchant_area'];
        $model->merchant_seats=$post['merchant_seats'];
        $model->merchant_telphone=$post['merchant_telphone'];
        $model->address=$post['address'];
        $model->shop_lng=$post['shop_lng'];
        $model->shop_lat=$post['shop_lat'];
        $model->business_license_path=$post['business_license_path'];
        $model->food_license_path=$post['food_license_path'];
        $model->create_time=time();
        //城市信息代码处理
        $region_code=Region::city($post);
        $model->region_code=$region_code;
        $model->shop_status=$post['shop_status'];
        $res=$model->save();
        $shop_id=$model->shop_id;
        //存账号
        $model=new ShopUser();
        $model->shop_id=$shop_id;
        $model->shop_user=$post['shop_user'];
        $model->password=setpassword($post['password']);
        $model->user_status=1;
        //获取管理员的ID
        $cookie = \Yii::$app->request->cookies;
        $user_id=$cookie->getValue('user_id');
        $model->operator_id=$user_id;
        $model->create_time=time();
        $res=$model->save();
        //创建商铺账户
        $model=new ShopAccount();
        $model->shop_id=$shop_id;
        $model->create_time=time();
        $model->save();
        //存分佣比例
        $model=new Commission();
        $model->shop_id=$shop_id;
        $model->commission_rate=$post['commission_rate'];
        $model->operator_id=1;
        $model->create_time=time();


        $model->save();

        return $res;


    }
    public static function ShopValidation($post=null)
    {
        $shop_user=$post['shop_user'];
        $res=ShopUser::ShopUser($shop_user);
        if(!empty($res))
        {
            throw new Exception('已存在该用户');
        }

    }
    public static function ShopEditInfo($shop_id)
    {
        $arr=Shop::find()->where(['shop_id'=>$shop_id])->asArray()->one();
        $arr['business_license_path']=$arr['business_license_path'] ? imageurl($arr['business_license_path']) : '';
        $arr['food_license_path']=$arr['food_license_path'] ? imageurl($arr['food_license_path']) : '';
        $commission_rate=Commission::GetCommissionRate($shop_id);
        $arr['commission_rate']=$commission_rate;
        $region_code=$arr['region_code'];
        $shop_user=ShopUser::find()->where(['shop_id'=>$shop_id])->asArray()->one();
        $arr['shop_user']=$shop_user['shop_user'];
        $post=Region::recity($region_code);
        $data['arr']=$arr;
        $data['post']=$post;
        return $data;

    }
    public static function ShopEdit($post)
    {
        $model=Shop::find()->where(['shop_id'=>$post['shop_id']])->one();
        $model->shop_name=$post['shop_name'];
        $model->merchant_name=$post['merchant_name'];
        $model->merchant_mobile=$post['merchant_mobile'];
        $model->merchant_area=$post['merchant_area'];
        $model->merchant_seats=$post['merchant_seats'];
        $model->merchant_telphone=$post['merchant_telphone'];
        $model->address=$post['address'];
        $model->shop_lng=$post['shop_lng'];
        $model->shop_lat=$post['shop_lat'];
        $model->update_time=time();
        //判断营业证是否更新
        if(!empty($post['business_license_path']))
        {
            $model->business_license_path=$post['business_license_path'];
        }
        if(!empty($post['food_license_path']))
        {
            $model->food_license_path=$post['food_license_path'];
        }
        //城市信息代码处理
        $region_code=Region::city($post);
        $model->region_code=$region_code;
        $model->shop_status=$post['shop_status'];
        //管理员储存
        $cookie = \Yii::$app->request->cookies;
        $user_id=$cookie->getValue('user_id');
        $model->operator_id=$user_id;
        $res=$model->update();
        //账号修改
        $model=ShopUser::find()->where(['shop_id'=>$post['shop_id']])->one();
        $model->shop_user=$post['shop_user'];
        $model->update_time=time();
        $res=$model->update();
        //判断分佣比例是否被修改
        $commission_model=Commission::find()->where(['shop_id'=>$post['shop_id']])->one();
        if (empty($commission_model)) {
            //存分佣比例
            $model=new Commission();
            $model->shop_id=$post['shop_id'];
            $model->commission_rate=$post['commission_rate'];
            $model->operator_id=$user_id;
            $model->create_time=time();
            $model->save();
        }else{
            if ($commission_model->commission_rate !==$post['commission_rate']) {
                $model =$commission_model;
                $model->commission_rate=$post['commission_rate'];
                $model->operator_id=$user_id;
                $model->save(false);
            }
        }
        return $res;

    }
    public static function RePassword($shop_id)
    {
        $model=ShopUser::find()->where(['shop_id'=>$shop_id])->one();
        $model->password=setpassword('123456');
        $res=$model->update();
        return $res;
    }
}