<?php
class Report{
	function __construct($ary){
		$this->ary = $ary;
		$this->uniAry = $this->uniqueAry();
	}
	function uniqueAry($dataSetAry=''){
		$ary = empty($dataSetAry)?$this->ary:$dataSetAry;
		$uniqueAry = [];
		for($i=0;$i<count($ary);$i++){
			for($j=0;$j<count($ary[$i]);$j++){
				if(isset($ary[$i][$j])){
					if(!in_array($ary[$i][$j],$uniqueAry,true)){
						array_push($uniqueAry,$ary[$i][$j]);
					}
				}
			}
		}
		return $uniqueAry;
	}
	function getSupportConfidence($A,$B='',$C='',$dataSetAry=''){
		$ary = empty($dataSetAry)?$this->ary:$dataSetAry;
		if($B==''){
			$B=$A;
		}
		if($C==''){
			$C=$A;
		}
		$support = 0;
		$freqA = 0;
		$freqB = 0;
		for($i=0;$i<count($ary);$i++){
			$isA = false;
			$isB = false;
			$isC = false;
			for($j=0;$j<count($ary[$i]);$j++){
				if($ary[$i][$j]==$A){
					$isA = true;
					$freqA++;
				}
				if($ary[$i][$j]==$B){
					$isB = true;
					$freqB++;
				}
				if($ary[$i][$j]==$C){
					$isC = true;
				}
			}
			if($isA&&$isB&&$isC){
				$support++;
			}
		}
		if($support!=0){
			$supportPercent = round($support/count($ary),4);
			$confidencePercent = round($support/$freqA,4);
			$lift = round(($support/$freqA)/($freqB/count($ary)),4);
			if($C!=$A){$confidencePercent='';$lift='';}
			$res = [
				'S'=>$supportPercent,'C'=>$confidencePercent,'L'=>$lift,
				'S%'=>($supportPercent*100).'%','C%'=>($confidencePercent*100).'%','L%'=>($lift*100).'%',
				'S/'=>$support.'/'.count($ary),'C/'=>$support.'/'.$freqA,'L/'=>$support.'/'.$freqA.'/('.$freqB.'/'.count($ary).')'
			];
			return $res;
		}
	}
	function aprior($minS=0,$cut=1,$u='%'){
		if($minS>1){
			echo 'Error: Support_min cannot greater than 1';
			return false;
		}
		if($cut>3||$cut<1){
			echo 'Error: Cut times must be set in [1,3]';
			return false;
		}
		$uniAry = $this->uniAry;
		$freqSubset1 = array();
		$freqSubset2 = array();
		$freqSubset3 = array();
		for($i=0;$i<count($uniAry);$i++){
			$res = $this->getSupportConfidence($uniAry[$i]);
			if($res['S'] >= $minS && !empty($res['S'])){//Cut 1
				array_push($freqSubset1,[$uniAry[$i] , $res['S'.$u] , $res['C'.$u] , $res['L'.$u]]);
			}
		}
		for($i=0;$i<count($freqSubset1);$i++){
			$A = $freqSubset1[$i][0];
			for($j=$i+1;$j<count($freqSubset1);$j++){
				$B = $freqSubset1[$j][0];
				$res = $this->getSupportConfidence($A,$B);
				if($res['S'] >= $minS && !empty($res['S'])){//Cut 2
					array_push($freqSubset2,[$A.','.$B , $res['S'.$u] , $res['C'.$u] , $res['L'.$u]]);
				}
			}
		}
		$fs2Str = '';
		for($i=0;$i<count($freqSubset2);$i++){
			$fs2Str .= $freqSubset2[$i][0].',';
		}
		$fs2Ary = array_unique(explode(',',$fs2Str));
		$fs2UniAry = array();$i=0;
		foreach($fs2Ary as $key=>$value){
			if($value!=''){
				$fs2UniAry[$i]=$value;
				$i++;
			}
		}
		for($i=0;$i<count($fs2UniAry);$i++){
			$A = $fs2UniAry[$i];
			for($j=$i+1;$j<count($fs2UniAry);$j++){
				$B = $fs2UniAry[$j];
				for($v=$j+1;$v<count($fs2UniAry);$v++){
					$C = $fs2UniAry[$v];
					$res = $this->getSupportConfidence($A,$B,$C);
					if($res['S'] >= $minS && !empty($res['S'])){//Cut 3
						array_push($freqSubset3,[$A.','.$B.','.$C , $res['S'.$u] , $res['C'.$u] , $res['L'.$u]]);
					}
				}
			}
		} 
		$res = 'freqSubset'.$cut;
		return $$res;
	}
}
?>