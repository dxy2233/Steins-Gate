function delete_bond(obj,bank_id){
    	 	if (confirm("确认删除？")) {
    	 		if (bank_id!='') {
    	 			$.ajax({
					cache: false,
					type: "POST",
					url: "/money/mywallet/delete",
					data: {bank_id:bank_id},
					success: function(result) {
						if (result.status == 1) {
							alert('删除成功');
    	 					$(obj).parents().parents().parents(".bd_yhka").remove(); 
						} else {
							alert('删除失败');
						}
					},
					error: function(result) {
						alert("异常", {
							icon: 2
						});
					}
				});
    	 		};
    	 	};
    	 	
    	 }