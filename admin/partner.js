	function mOvr(src,clrOver){ 
		if (!src.contains(event.fromElement)){ src.style.cursor = 'hand'; src.bgColor = clrOver;}
	} 
	
	function mOut(src,clrIn){ 
		if (!src.contains(event.toElement)){ src.style.cursor = 'default'; src.bgColor = clrIn; }
	}
	
	function selectRow(row){
		document.getElementById(row).style.background="#D6DEEC";
	}
 
	function deselectRow(row){
		document.getElementById(row).style.background="";
	}
	
	function selectAll(rows){
			var k=1;
			var count=rows;
			if(document.getElementById("checkAll").checked==true)
			{	
				while(k<=count){
					
					document.getElementById("check"+k+"").checked=true; 
					document.getElementById("tr"+k+"").style.background='#D6DEEC'; 
					k++; 
					
					
				}
			} else {
				
				while(k<=count){
					document.getElementById("check"+k+"").checked=false; 
					document.getElementById("tr"+k+"").style.background=''; 
					k++; 
				}
			}
			
	}
