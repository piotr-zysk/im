function KampUpdate(e, dd)
{
	for (j=1; j < dd.length; j++)
	{
		dd[j][0] = true;
	}

	for (j=1; j < dd[0].length; j++)
	{
		for (i=1; i < dd.length; i++)
		{
			current = dd[i][j].split("|");
			value = current[0];
			choice = current[0];
			if (current.length == 2) choice = current[1];
			if (value != document[dd[0][0]][dd[0][j]][document[dd[0][0]][dd[0][j]].selectedIndex].value) dd[i][0] = false;
		}
		if (e == document[dd[0][0]][dd[0][j]])
		{
			KampDropdown(j+1,dd);
			for (k=j+2; k < dd[0].length; k++)
			{
				document[dd[0][0]][dd[0][k]].length = 0;
			}
			break;
		}
	}
}

function KampDropdown(item,dd)
{
	var pre1 = "";
	var j = 1;
	document[dd[0][0]][dd[0][item]].options.length = 0;
	document[dd[0][0]][dd[0][item]].options[0] = new Option('Wybierz ' + dd[0][item], '');
	document[dd[0][0]][dd[0][item]].options[0].selected = true;
	for (i=1; i < dd.length; i++)
	{
		if (dd[i][0] || item == 1)
		{
			current = dd[i][item].split("|");
			value = current[0];
			choice = current[0];
			if (current.length == 2) choice = current[1];
			if (value != pre1)
			{
				var op = new Option(choice, value);
				document[dd[0][0]][dd[0][item]].options[j] = op;
				j++;
				pre1 = value;
			}
		}
	}
}
