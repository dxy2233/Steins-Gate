<?php
namespace app\modules\banquet\models;

use common\models\BanquetMenu;
use common\models\BanquetType;
use common\models\Shop;
use common\models\ShopBanquet;
use yii\base\Model;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/19
 * Time: 11:07
 */
class ShopbanqueDo extends Model
{
  public static function ShopbanqueList($post=null)
  {
      $query=new Query();
      $query->select([
          'sb.*',
          's.shop_name',
          'bt.type_name'
      ]);
      $query->from([
          'sb' => ShopBanquet::tableName()
      ]);
      $query->leftJoin([
          's' => Shop::tableName()
      ], 's.shop_id = sb.shop_id');
      $query->leftJoin([
          'bt' => BanquetType::tableName()
      ], 'bt.type_id = sb.type_id');
      //商铺名字
      if(!empty($post['shop_name']))
      {
          $query->andWhere([
              'like',
              's.shop_name',
              $post['shop_name']
          ]);
      }
      //流水席名称
      if(!empty($post['banquet_name']))
      {
          $query->andWhere([
              'like',
              'sb.banquet_name',
              $post['banquet_name']
          ]);
      }
      //流水席编号
      if(!empty($post['banquet_id']))
      {
          $query->andWhere([
              'sb.banquet_id' => $post['banquet_id']
          ]);
      }

      //流水席类别
      if(!empty($post['type_id']))
      {
          $query->andWhere([
              'bt.type_id' => $post['type_id']
          ]);
      }

      $data=$query->all();
      $data=fenye($data);
      $data['post']=$post;
      $data['type']=BanquetType::getAllType();
      return $data;

  }
  public static function ShopbanqueInfo($id)
  {
      $query=new Query();
      $query->select([
          'sb.*',
          's.shop_name',
          's.merchant_telphone',
          's.address',
          'bt.type_name'
      ]);
      $query->from([
          'sb' => ShopBanquet::tableName()
      ]);
      $query->leftJoin([
          's' => Shop::tableName()
      ], 's.shop_id = sb.shop_id');
      $query->leftJoin([
          'bt' => BanquetType::tableName()
      ], 'bt.type_id = sb.type_id');
      $query->andWhere([
          'sb.banquet_id' => $id
      ]);
      $data=$query->one();

      return $data;

  }
  public static function BanquetmenuInfo($id)
  {
      $query=new Query();
      $query->select([
          'bm.*'
      ]);
      $query->from([
          'bm' => BanquetMenu::tableName()
      ]);
      $query->andWhere([
          'bm.banquet_id' => $id
      ]);
      $data=$query->all();
      $page=gets('page');
      if(empty($page))
      {
          $page=1;
      }
      $data=fenye($data,$page,2);
      return $data;
  }

}