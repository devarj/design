<?php

Class Autoship_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function insert_autoship($data)
    {
        $this->db->insert('auto_ship', $data);
        return $this->db->insert_id();
    }

    function insert_autoship_details($data)
    {
        $this->db->insert('auto_ship_details', $data);
        return $this->db->insert_id();
    }

    function view_all()
    {
//          $sql = $this->db->query('SELECT * FROM auto_ship INNER JOIN auto_ship_details ON auto_ship.id=auto_ship_details.ship_id  ');
        $sql = $this->db->query('SELECT * FROM auto_ship   ');
        return $sql->result();
    }

    function view_byShipID($shipID)
    {
        $sql = $this->db->query('SELECT p.name,asd.quantity,asd.price FROM auto_ship_details asd   INNER JOIN products p ON asd.product_id = p.id   WHERE ship_id = ' . $shipID . '   ');
        return $sql->result();
    }

    function get_productbyShipID($shipID)
    {
        $sql = $this->db->query('SELECT * FROM auto_ship_details asd     WHERE ship_id = ' . $shipID . '   ');
        return $sql->result();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('auto_ship');

        //now delete the order items
        $this->db->where('ship_id', $id);
        $this->db->delete('auto_ship_details');
    }

    function get_cron()
    {
        $sql = $this->db->query('SELECT as1.*
  FROM auto_ship as1 WHERE DAY(CURRENT_DATE()) >= DAY(as1.cron_date) 
  AND YEAR(CURRENT_DATE()) = YEAR(as1.cron_date) 
  AND MONTH(CURRENT_DATE()) = MONTH(as1.cron_date)');
        return $sql->result();
    }

    function save_order($data, $contents = false)
    {
        if (isset($data['id']))
        {
            $this->db->where('id', $data['id']);
            $this->db->update('orders', $data);
            $id = $data['id'];

            // we don't need the actual order number for an update
            $order_number = $id;
        }
        else
        {
            $this->db->insert('orders', $data);
            $id = $this->db->insert_id();

            $order = array('order_number' => 'EG' . date('U') . $id);

            $this->db->where('id', $id);
            $this->db->update('orders', $order);

            $order_number = $order['order_number'];
        }

        //if there are items being submitted with this order add them now
        if ($contents)
        {
            // clear existing order items
            $this->db->where('order_id', $id)->delete('order_items');
            // update order items
            foreach ($contents as $item)
            {
                $save = array();
                $details = $this->getproduct($item->id);
                $details = json_decode(json_encode($details), true);
                $save['contents'] = serialize($details);
                $save['product_id'] = $item->id;
                $save['quantity'] = $item->quantity;
                $save['order_id'] = $id;
                $this->db->insert('order_items', $save);
            }
        }

        return $order_number;
    }

    function getproduct($id)
    {
        $sql = $this->db->query('SELECT * FROM products where id= ' . $id . '  ');
        return $sql->result();
    }

    function getaddress($customerid)
    {
        $sql = $this->db->query('SELECT * FROM autoship_address_bank where customer_id= ' . $customerid . '  ');
        return $sql->result();
    }

    function save_address($data)
    {
        // prepare fields for db insertion
        $data['field_data'] = serialize($data['field_data']);
        // update or insert
        if (!empty($data['id']))
        {
            $this->db->where('id', $data['id']);
            $this->db->update('autoship_address_bank', $data);
            return $data['id'];
        }
        else
        {
            //only one address per customer
            $this->db->where('customer_id', $data['customer_id'])->delete('autoship_address_bank');
            $this->db->insert('autoship_address_bank', $data);
            return $this->db->insert_id();
        }
    }

    /*
      function get_gross_monthly_sales($year)
      {
      $this->db->select('SUM(coupon_discount) as coupon_discounts');
      $this->db->select('SUM(gift_card_discount) as gift_card_discounts');
      $this->db->select('SUM(subtotal) as product_totals');
      $this->db->select('SUM(shipping) as shipping');
      $this->db->select('SUM(tax) as tax');
      $this->db->select('SUM(total) as total');
      $this->db->select('YEAR(ordered_on) as year');
      $this->db->select('MONTH(ordered_on) as month');
      $this->db->group_by(array('MONTH(ordered_on)'));
      $this->db->order_by("ordered_on", "desc");
      $this->db->where('YEAR(ordered_on)', $year);

      return $this->db->get('orders')->result();
      }

      function get_sales_years()
      {
      $this->db->order_by("ordered_on", "desc");
      $this->db->select('YEAR(ordered_on) as year');
      $this->db->group_by('YEAR(ordered_on)');
      $records = $this->db->get('orders')->result();
      $years = array();
      foreach ($records as $r)
      {
      $years[] = $r->year;
      }
      return $years;
      }

      function get_orders($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0)
      {
      if ($search)
      {
      if (!empty($search->term))
      {
      //support multiple words
      $term = explode(' ', $search->term);

      foreach ($term as $t)
      {
      $not = '';
      $operator = 'OR';
      if (substr($t, 0, 1) == '-')
      {
      $not = 'NOT ';
      $operator = 'AND';
      //trim the - sign off
      $t = substr($t, 1, strlen($t));
      }

      $like = '';
      $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
      $like .= $operator . " `bill_firstname` " . $not . "LIKE '%" . $t . "%'  ";
      $like .= $operator . " `bill_lastname` " . $not . "LIKE '%" . $t . "%'  ";
      $like .= $operator . " `ship_firstname` " . $not . "LIKE '%" . $t . "%'  ";
      $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
      $like .= $operator . " `status` " . $not . "LIKE '%" . $t . "%' ";
      $like .= $operator . " `notes` " . $not . "LIKE '%" . $t . "%' )";

      $this->db->where($like);
      }
      }
      if (!empty($search->start_date))
      {
      $this->db->where('ordered_on >=', $search->start_date);
      }
      if (!empty($search->end_date))
      {
      //increase by 1 day to make this include the final day
      //I tried <= but it did not function. Any ideas why?
      $search->end_date = date('Y-m-d', strtotime($search->end_date) + 86400);
      $this->db->where('ordered_on <', $search->end_date);
      }
      }

      if ($limit > 0)
      {
      $this->db->limit($limit, $offset);
      }
      if (!empty($sort_by))
      {
      $this->db->order_by($sort_by, $sort_order);
      }

      return $this->db->get('orders')->result();
      }

      function get_orders_count($search = false)
      {
      if ($search)
      {
      if (!empty($search->term))
      {
      //support multiple words
      $term = explode(' ', $search->term);

      foreach ($term as $t)
      {
      $not = '';
      $operator = 'OR';
      if (substr($t, 0, 1) == '-')
      {
      $not = 'NOT ';
      $operator = 'AND';
      //trim the - sign off
      $t = substr($t, 1, strlen($t));
      }

      $like = '';
      $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
      $like .= $operator . " `bill_firstname` " . $not . "LIKE '%" . $t . "%'  ";
      $like .= $operator . " `bill_lastname` " . $not . "LIKE '%" . $t . "%'  ";
      $like .= $operator . " `ship_firstname` " . $not . "LIKE '%" . $t . "%'  ";
      $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
      $like .= $operator . " `status` " . $not . "LIKE '%" . $t . "%' ";
      $like .= $operator . " `notes` " . $not . "LIKE '%" . $t . "%' )";

      $this->db->where($like);
      }
      }
      if (!empty($search->start_date))
      {
      $this->db->where('ordered_on >=', $search->start_date);
      }
      if (!empty($search->end_date))
      {
      $this->db->where('ordered_on <', $search->end_date);
      }
      }

      return $this->db->count_all_results('orders');
      }

      //get an individual customers orders
      function get_customer_orders($id, $offset = 0)
      {
      $this->db->join('order_items', 'orders.id = order_items.order_id');
      $this->db->order_by('ordered_on', 'DESC');
      return $this->db->get_where('orders', array('customer_id' => $id), 15, $offset)->result();
      }

      function count_customer_orders($id)
      {
      $this->db->where(array('customer_id' => $id));
      return $this->db->count_all_results('orders');
      }

      function get_order($id)
      {
      $this->db->where('id', $id);
      $result = $this->db->get('orders');

      $order = $result->row();
      $order->contents = $this->get_items($order->id);

      return $order;
      }

      function get_items($id)
      {
      $this->db->select('order_id, contents');
      $this->db->where('order_id', $id);
      $result = $this->db->get('order_items');

      $items = $result->result_array();

      $return = array();
      $count = 0;
      foreach ($items as $item)
      {

      $item_content = unserialize($item['contents']);

      //remove contents from the item array
      unset($item['contents']);
      $return[$count] = $item;

      //merge the unserialized contents with the item array
      $return[$count] = array_merge($return[$count], $item_content);

      $count++;
      }
      return $return;
      }

      function delete($id)
      {
      $this->db->where('id', $id);
      $this->db->delete('orders');

      //now delete the order items
      $this->db->where('order_id', $id);
      $this->db->delete('order_items');
      }

      function update_order($data)
      {
      $this->db->where('order_number', $data['order_number']);
      $this->db->update('orders', $data);
      }

      function save_order($data, $contents = false)
      {
      if (isset($data['id']))
      {
      $this->db->where('id', $data['id']);
      $this->db->update('orders', $data);
      $id = $data['id'];

      // we don't need the actual order number for an update
      $order_number = $id;
      }
      else
      {
      $this->db->insert('orders', $data);
      $id = $this->db->insert_id();

      //create a unique order number
      //unix time stamp + unique id of the order just submitted.
      $order = array('order_number' => 'EG' . date('U') . $id);

      //update the order with this order id
      $this->db->where('id', $id);
      $this->db->update('orders', $order);

      //return the order id we generated
      $order_number = $order['order_number'];
      }

      //if there are items being submitted with this order add them now
      if ($contents)
      {
      // clear existing order items
      $this->db->where('order_id', $id)->delete('order_items');
      // update order items
      foreach ($contents as $item)
      {
      $save = array();
      $save['contents'] = $item;

      $item = unserialize($item);
      $save['product_id'] = $item['id'];
      $save['quantity'] = $item['quantity'];
      $save['order_id'] = $id;
      $this->db->insert('order_items', $save);
      }
      }

      return $order_number;
      }

      function get_best_sellers($start, $end)
      {
      if (!empty($start))
      {
      $this->db->where('ordered_on >=', $start);
      }
      if (!empty($end))
      {
      $this->db->where('ordered_on <', $end);
      }

      // just fetch a list of order id's
      $orders = $this->db->select('id')->get('orders')->result();

      $items = array();
      foreach ($orders as $order)
      {
      // get a list of product id's and quantities for each
      $order_items = $this->db->select('product_id, quantity')->where('order_id', $order->id)->get('order_items')->result_array();

      foreach ($order_items as $i)
      {

      if (isset($items[$i['product_id']]))
      {
      $items[$i['product_id']] += $i['quantity'];
      }
      else
      {
      $items[$i['product_id']] = $i['quantity'];
      }
      }
      }
      arsort($items);

      // don't need this anymore
      unset($orders);

      $return = array();
      foreach ($items as $key => $quantity)
      {
      $product = $this->db->where('id', $key)->get('products')->row();
      if ($product)
      {
      $product->quantity_sold = $quantity;
      }
      else
      {
      $product = (object) array('sku' => 'Deleted', 'name' => 'Deleted', 'quantity_sold' => $quantity);
      }

      $return[] = $product;
      }

      return $return;
      }
     */
}
