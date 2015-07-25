function value(type, id, islike, isView)
{ 	
	var url="index.php?r=question/"
	if (islike){
		url +="dislike&type="+type+"&id="+id
	} else {
		url +="like&type="+type+"&id="+id
	}
	$.ajax({
		url:url,
		success:function(){
			if (islike) {
				if(isView){
					$("#"+type+id).attr("class","icon-heart-empty");
				} else {
					$("#"+type+id).attr("class","icon-heart-empty icon-2x");
				}
				$("#"+type+id).attr("onclick","value('"+type+"',"+id+", 0,"+isView+")");
				document.getElementById("like"+type+"Count"+id).innerHTML--; 
			} else {
				if (isView) {
					$("#"+type+id).attr("class","icon-heart");
				} else {
					$("#"+type+id).attr("class","icon-heart icon-2x");
				}
				$("#"+type+id).attr("onclick","value('"+type+"',"+id+", 1, "+isView+")");
				document.getElementById("like"+type+"Count"+id).innerHTML++; 
			}
			
		}
	});
}
