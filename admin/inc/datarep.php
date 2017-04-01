<?php
class Report{
	function __construct($ary){
		$this->ary = $ary;
		$this->uniAry = $this->uniqueAry();
	}
	function randomText($length=6){
		$length=(int)$length;
		if($length>32||$length<3){
			$length==6;
		}
		return base64_encode(mcrypt_create_iv($length,MCRYPT_DEV_RANDOM));
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
	function linearRegression($x=0){
		$aSum = 0;
		$bSum = 0;
		$a2Sum = 0;
		$abProSum = 0;
		for($i=0;$i<count($ary);$i++){
			$abProSum += $this->ary[$i][0] * $this->ary[$i][1];
			$aSum += $this->ary[$i][0];
			$bSum += $this->ary[$i][1];
			$a2Sum += pow($this->ary[$i][0],2);
		}
		$denominator = count($ary)*$a2Sum - pow($aSum,2);
		$k = (count($ary)*$abProSum - $aSum*$bSum)/$denominator;
		$c = ($a2Sum*$bSum - $aSum*$abProSum)/$denominator;
		$y = $k*$x+$c;
		echo "f(x)=".$k."x+".$c.'<br/>';
		echo "x = $x <br/> y = $y";
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
		$supportPercent = round($support/count($ary),4);
		$confidencePercent = round($support/$freqA,4);
		$lift = round(($support/$freqA)/($freqB/count($ary)),4);
		$res = [
			'S'=>$supportPercent,'C'=>$confidencePercent,'L'=>$lift,
			'S%'=>($supportPercent*100).'%','C%'=>($confidencePercent*100).'%','L%'=>($lift*100).'%',
			'S/'=>$support.'/'.count($ary),'C/'=>$support.'/'.$freqA,'L/'=>$support.'/'.$freqA.'/('.$freqB.'/'.count($ary).')'
		];
		return $res;
	}
	function find2SC($minS=0,$minC=0,$u='%',$dataSetAry=''){
		if($minS>1||$minC>1){
			echo 'Error: Support_min or Confidence_min cannot greater than 1';
			return false;
		}
		$ary = empty($dataSetAry)?$this->ary:$dataSetAry;
		$uniAry = $this->uniqueAry();
		for($i=0;$i<count($uniAry);$i++){
			$A = $uniAry[$i];
			for($j=$i+1;$j<count($uniAry);$j++){
				$B = $uniAry[$j];
				$A_B = $this->getSupportConfidence($A,$B);
				$B_A = $this->getSupportConfidence($B,$A);
				if($A_B['S']>=$minS&&$A_B['C']>=$minC){
					echo $A.'->'.$B.': S/'.$A_B['S'.$u].',&nbsp;C/'.$A_B['C'.$u].'&nbsp;L/'.$A_B['L'.$u].'&nbsp;';
				}
				if($B_A['S']>=$minS&&$B_A['C']>=$minC){
					echo $B.'->'.$A.': S/'.$B_A['S'.$u].',&nbsp;C/'.$B_A['C'.$u].'&nbsp;L/'.$B_A['L'.$u].'<br/>';
				}
			}
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
			if($this->getSupportConfidence($uniAry[$i])['S'] >= $minS){//Cut 1
				array_push($freqSubset1,[$uniAry[$i] , $this->getSupportConfidence($uniAry[$i])['S'.$u]]);
			}
		}
		for($i=0;$i<count($freqSubset1);$i++){
			$A = $freqSubset1[$i][0];
			for($j=$i+1;$j<count($freqSubset1);$j++){
				$B = $freqSubset1[$j][0];
				if($this->getSupportConfidence($A,$B)['S'] >= $minS){//Cut 2
					array_push($freqSubset2,[$A.','.$B , $this->getSupportConfidence($A,$B)['S'.$u]]);
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
					if($this->getSupportConfidence($A,$B,$C)['S'] >= $minS){//Cut 3
						array_push($freqSubset3,[$A.','.$B.','.$C , $this->getSupportConfidence($A,$B,$C)['S'.$u]]);
					} 
						
				}
			}
		} 
		$res = 'freqSubset'.$cut;
		return $$res;
	}
}
?>