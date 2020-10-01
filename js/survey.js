// JavaScript Document
function AddOption()
{
		selectbox=document.getElementById("lst_survey_choices");
		text=document.form5.txt_choice.value;
		value=document.form5.txt_choice.value;
		if((value==" ") || (value==""))
			alert("Please enter the choice");
		else
		{
			var optn = document.createElement("OPTION");
			optn.text = text;
			optn.value = value;
			selectbox.options.add(optn);
			hdn_value=document.getElementById("hdn_survey_choices");
			hdn_value.value=hdn_value.value+value+",";
		}
		document.form5.txt_choice.value="";
		document.form5.txt_choice.focus();
}

function RemoveOption()
{
	selectbox=document.getElementById("lst_survey_choices");
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		if(selectbox.options[i].selected)
		{
			selectbox.remove(i);
			hdn_value=document.getElementById("hdn_survey_choices").value;
			hdn_value_arr=hdn_value.split(",");
			hdn_value_arr[i]=hdn_value_arr[i]+",";
			document.getElementById("hdn_survey_choices").value=hdn_value.replace(hdn_value_arr[i],"");
		}
	}
	document.form5.txt_choice.value="";
	document.form5.txt_choice.focus();
}