<?php

Class Category_model extends CI_Model
{

    function get_categories($parent = false)
    {
        if ($parent !== false)
        {
            $this->db->where('parent_id', $parent);
        }
        $this->db->select('id');
        $this->db->where('enable', '1');
        $this->db->order_by('categories.sequence', 'ASC');

        //this will alphabetize them if there is no sequence
        $this->db->order_by('name', 'ASC');
        $result = $this->db->get('categories');

        $categories = array();
        foreach ($result->result() as $cat)
        {
            $categories[] = $this->get_category($cat->id);
        }
//		print_r($categories);
        return $categories;
    }

    function get_main_category($parent = false)
    {
        if ($parent !== false)
        {
            $this->db->where('id', $parent);
        }
        $this->db->select('name');
        $this->db->order_by('categories.sequence', 'ASC');

        //this will alphabetize them if there is no sequence
        $this->db->order_by('name', 'ASC');
        $result = $this->db->get('categories');

        return $result->result();
    }

    //this is for building a menu
    function get_categories_tierd($parent = 0)
    {
        $categories = array();
        $result = $this->get_categories($parent);
        foreach ($result as $category)
        {
            $categories[$category->id]['category'] = $category;
            $categories[$category->id]['children'] = $this->get_categories_tierd($category->id);
        }
        return $categories;
    }
    
    //this is for building a menu in admin module
    function get_admin_categories_tierd($parent = 0)
    {
        $categories = array();
        $result = $this->get_admin_categories($parent);
        foreach ($result as $category)
        {
            $categories[$category->id]['category'] = $category;
            $categories[$category->id]['children'] = $this->get_admin_categories_tierd($category->id);
        }
        return $categories;
    }
    
    function get_admin_categories($parent = false)
    {
        if ($parent !== false)
        {
            $this->db->where('parent_id', $parent);
        }
        $this->db->select('id');
        $this->db->order_by('categories.sequence', 'ASC');

        //this will alphabetize them if there is no sequence
        $this->db->order_by('name', 'ASC');
        $result = $this->db->get('categories');

        $categories = array();
        foreach ($result->result() as $cat)
        {
            $categories[] = $this->get_category($cat->id);
        }
        return $categories;
    }

    function category_autocomplete($name, $limit)
    {
//        return $this->db->like('name', $name)->where('enable', '1')->get('categories', $limit)->result();
        return $this->db->like('name', $name)->get('categories', $limit)->result();
    }

    function check_daily($date)
    {
        $sql = $this->db->query('SELECT COUNT(*) AS numrows FROM daily_tip WHERE date=CURDATE()');
        return $sql->result();
    }

    function get_tip()
    {
        $sql = $this->db->query('SELECT * FROM tips ORDER BY RAND() LIMIT 1');
        return $sql->result();
    }

    function get_tiptoday()
    {
        $sql = $this->db->query('SELECT * FROM tips INNER JOIN daily_tip ON tips.id=daily_tip.tip_id WHERE date=CURDATE()');
        return $sql->result();
    }

    function insert_tip($id)
    {
        $sql = $this->db->query('INSERT INTO daily_tip (tip_id,date) VALUES (1,CURDATE())');
//        $sql->result();
    }

    function get_category_limit()
    {
        return $this->db->get_where('categories', array('parent_id' => '0'))->result();
    }

    function get_category($id)
    {
        return $this->db->get_where('categories', array('id' => $id))->row();
    }

    function get_category_products_admin($id)
    {
        $this->db->order_by('sequence', 'ASC');
        $result = $this->db->get_where('category_products', array('category_id' => $id));
        $result = $result->result();

        $contents = array();
        foreach ($result as $product)
        {
            $result2 = $this->db->get_where('products', array('id' => $product->product_id));
            $result2 = $result2->row();

            $contents[] = $result2;
        }

        return $contents;
    }

    function get_category_products($id, $limit, $offset)
    {
        $this->db->order_by('sequence', 'ASC');
        $result = $this->db->get_where('category_products', array('category_id' => $id), $limit, $offset);
        $result = $result->result();

        $contents = array();
        $count = 1;
        foreach ($result as $product)
        {
            $result2 = $this->db->get_where('products', array('id' => $product->product_id));
            $result2 = $result2->row();

            $contents[$count] = $result2;
            $count++;
        }

        return $contents;
    }

    function organize_contents($id, $products)
    {
        //first clear out the contents of the category
        $this->db->where('category_id', $id);
        $this->db->delete('category_products');

        //now loop through the products we have and add them in
        $sequence = 0;
        foreach ($products as $product)
        {
            $this->db->insert('category_products', array('category_id' => $id, 'product_id' => $product, 'sequence' => $sequence));
            $sequence++;
        }
    }

    function save($category)
    {
        if ($category['id'])
        {
            $this->db->where('id', $category['id']);
            $this->db->update('categories', $category);

            return $category['id'];
        }
        else
        {
            $this->db->insert('categories', $category);
            return $this->db->insert_id();
        }
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('categories');

        //delete references to this category in the product to category table
        $this->db->where('category_id', $id);
        $this->db->delete('category_products');
    }

    function getCategory($id)
    {
        $sql = $this->db->query('SELECT categories.id,reward_price,reward_points FROM category_products INNER JOIN categories ON category_products.category_id=categories.id  WHERE category_products.product_id='.$id.' limit 1 ');
//        $sql = $this->db->query('SELECT * FROM category_products '
//                . 'INNER JOIN categories ON category_products.category_id=categories.id '
//                . 'INNER JOIN products ON products.id=category_products.product_id '
//                . ' WHERE category_products.product_id='.$id.' limit 1 ');
        return $sql->result();
    }
    
    function count_categories()
	{
		return $this->db->count_all_results('categories');
	}
    
    function update_category($enable, $id)
    {
        $data['enable'] = $enable;
        $this->db->where('id', $id);
        $this->db->update('categories', $data);
    }

}
