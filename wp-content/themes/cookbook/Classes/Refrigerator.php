<?php
namespace CookBook\Classes;
class Refrigerator{
    const addRefrigerator = 'addRefrigerator';
    const deleteRefrigerator = 'deleteRefrigerator';

    public function __construct()
    {

    }

    public function addRefrigerator($request)
    {
        session_start();
        $_SESSION[$request['act']][] = [
            'term_id' => $request['term_id'],
            'term'    => $request['term'],
        ];

        if(is_user_logged_in()){
            update_user_meta(get_current_user_id(), 'cookbook_refrigerator_materials', $_SESSION[$request['act']]);
        }

        $result = json_encode($request);
        echo $result;
    }

    public function deleteRefrigerator($request)
    {
        session_start();
        foreach ($_SESSION[SELF::addRefrigerator] as $index => $item) {
            if($item['term_id'] == $request['term_id']){
                unset($_SESSION[SELF::addRefrigerator][$index]);
            }
        }
        if(is_user_logged_in()){
            update_user_meta(get_current_user_id(), 'cookbook_refrigerator_materials', $_SESSION[$request['act']]);
        }
    }

    public function hasAddRefrigerator()
    {
        if(!empty($_SESSION[SELF::addRefrigerator])){
            return true;
        }

        if(is_user_logged_in()){
            $data = get_user_meta(get_current_user_id(), 'cookbook_refrigerator_materials', true);
            if($data){
                $_SESSION[SELF::addRefrigerator] = get_user_meta(get_current_user_id(), 'cookbook_refrigerator_materials', true);
                return true;
            }

        }
        return false;
    }

    public function getTerms($term_id = 'term_id')
    {
        $ra = [];
        if($this->hasAddRefrigerator()){
            $ra = wp_list_pluck($_SESSION[SELF::addRefrigerator], $term_id);
            return $ra;
        }
        return $ra;
    }

    public function getPosts()
    {
        $args = [];
        if($this->hasAddRefrigerator()){
            global $POSTTYPES;
            $args = array(
                'post_type' => $POSTTYPES,
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                'posts_per_page' => 16,
            );

            $terms = $this->getTerms();
            $taxquery = array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'material',
                        'field'    => 'term_id',
                        'terms'    => $terms,
                    ),
                ),
            );
            $args = array_merge($args, $taxquery);
            //return new \WP_Query($args);
        }
        return new \WP_Query($args);
    }

    public function getPosts2()
    {
        $args = [];
        if($this->hasAddRefrigerator()){
            $terms = $this->getTerms();
            $terms = implode("','", $terms);
            $sql_query = "
            SELECT *,
                   materialCnt - hasCnt AS remains
            FROM (
                     SELECT WP.*,
                            wt.*,
                            count(WP.id) AS hasCnt,
                            (SELECT count(*)
                             FROM wp_posts AS wp
                                      LEFT JOIN wp_term_relationships AS tr ON wp.id = tr.object_id
                                      LEFT JOIN wp_term_taxonomy wtt on tr.term_taxonomy_id = wtt.term_taxonomy_id
                                      LEFT JOIN wp_terms wt on wtt.term_id = wt.term_id
                             WHERE id = WP.id
                               AND taxonomy = 'material') AS materialCnt
                     FROM wp_posts AS WP
                              LEFT JOIN wp_term_relationships AS R ON WP.id = R.object_id
                              LEFT JOIN wp_term_taxonomy wtt on R.term_taxonomy_id = wtt.term_taxonomy_id
                              LEFT JOIN wp_terms wt on wtt.term_id = wt.term_id
                     WHERE wt.term_id IN ('$terms')
                       AND WP.post_status = 'publish'
                     GROUP BY WP.id
                 ) AS A ORDER BY remains
            ";

            $result = get_posts_custom_query($sql_query);
            return $result;
        }
        return new \WP_Query();
    }
}