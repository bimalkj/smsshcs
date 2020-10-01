// JavaScript Document
function add_Option()
{
		selectbox_A=document.getElementById("lst_column_A");
		selectbox_B=document.getElementById("lst_column_B");
		text_A=document.form2.txt_col_A.value;
		//text_A=text_A.trim();
		value_A=text_A;
		text_B=document.form2.txt_col_B.value;
		//text_B=text_B.trim();
		value_B=text_B;
		if(value_A.length != 0)
		{
			if(value_B.length != 0)
			{
				var optn_A = document.createElement("OPTION");
				var optn_B = document.createElement("OPTION");
				optn_A.text = text_A;
				optn_A.value = value_A;
				selectbox_A.options.add(optn_A);
				optn_B.text = text_B;
				optn_B.value = value_B;
				selectbox_B.options.add(optn_B);
				hdn_col_A=document.getElementById("hdn_col_A");
				hdn_col_A.value=hdn_col_A.value+value_A+",";
				hdn_col_B=document.getElementById("hdn_col_B");
				hdn_col_B.value=hdn_col_B.value+value_B+",";
			}
			else
			alert("Please fill the column A and column B");
		}
		else
		alert("Please fill the column A and column B");
		document.form2.txt_col_A.value="";
		document.form2.txt_col_B.value="";
		document.form2.txt_col_A.focus();
}

function remove_Option()
{
	selectbox_A=document.getElementById("lst_column_A");
	selectbox_B=document.getElementById("lst_column_B");
	var i;
	for(i=selectbox_A.options.length-1;i>=0;i--)
	{
		if(selectbox_A.options[i].selected)
		{
			selectbox_A.remove(i);
			selectbox_B.remove(i);
			hdn_col_A=document.getElementById("hdn_col_A").value;
			hdn_col_A_arr=hdn_col_A.split(",");
			hdn_col_A_arr[i]=hdn_col_A_arr[i]+",";
			document.getElementById("hdn_col_A").value=hdn_col_A.replace(hdn_col_A_arr[i],"");
			
			hdn_col_B=document.getElementById("hdn_col_B").value;
			hdn_col_B_arr=hdn_col_B.split(",");
			hdn_col_B_arr[i]=hdn_col_B_arr[i]+",";
			document.getElementById("hdn_col_B").value=hdn_col_B.replace(hdn_col_B_arr[i],"");
		}
	}
	document.form2.txt_col_A.value="";
	document.form2.txt_col_B.value="";
	document.form2.txt_col_A.focus();
}