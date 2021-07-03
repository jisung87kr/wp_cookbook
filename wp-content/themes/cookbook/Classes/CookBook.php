<?php
namespace CookBook\Classes;
use CookBook\Classes\Refrigerator;
class CookBook{
    public function __construct()
    {

    }

    public function materialPluck($group)
    {
        $materials = [];
        foreach ($group as $item) {
            foreach ($item['material_class'] as $index => $material) {
                $materials[] = $material['material_name'];
            }
        }

        return $materials;
    }

    function getMaterialDiff($group)
    {
//        $ra['total'] = get_post_field('materialCnt');
//        $ra['hasCnt'] = get_post_field('hasCnt');
//        $ra['remains'] = get_post_field('remains');
//        $ra['text'] = $ra['total'].'개의 재료 중 '.$ra['remains'].'개 부족';
        $ra = [];
        $Refrigerator = new Refrigerator();
        $materials = $this->materialPluck($group);
        $diff = array_diff($materials, $Refrigerator->getTerms('term'));
        $materialCnt = count($materials);
        $diffCnt = count($diff);
        $ra['total'] = $materialCnt;
        $ra['remains'] = $diffCnt;
        $ra['hasCnt'] = $materialCnt-$diffCnt;
        $ra['text'] = $ra['total'].'개의 재료 중 '.$ra['remains'].'개 부족';
        return $ra;
    }
}