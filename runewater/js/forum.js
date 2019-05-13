function forum(id){
	var url = 'xmlhttp/getforum.php?forum=' + id;
	xmlhttp.forumid = id;
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var div = document.getElementById("f" + xmlhttp.forumid);
			div.removeChild(div.childNodes[0]);
			
			var table = document.createElement("table");
			div.appendChild(table);//Das erste Objket im Profil
			
			var tr = document.createElement("tr");
				tr.setAttribute("class", "header");
			table.appendChild(tr);
			var th = document.createElement("th");
				var names = ["Allgemeines"];
				th.innerHTML = names[xmlhttp.forumid];
				th.setAttribute("colspan", "7");
			tr.appendChild(th);
			
			/* String to code */
			var output = xmlhttp.responseText;
			var str1,str2,str3,str4,str5,str6,str7,str_date,str_parts,tr,td,i,txt,img,br,div,textarea;
			if(output != 0){
				while (output != ""){
					//id("text",typ,date,user,visits,pins,vote)
					str1 = output.indexOf("(");
					str2 = output.indexOf('"');
					str3 = output.indexOf('"', str2 + 1);
					str4 = output.indexOf(")");
					str_date = output.substring(str3, str4).split(",")[2];
					str5 = str_date.indexOf("-");
					str6 = str_date.indexOf("-", str5 + 1);
					str7 = str_date.indexOf(" ", str6 + 1);
					str_parts = [
						output.substring(0, str1),					//0 - id
						output.substring(str2+1, str3),				//1 - text
						output.substring(str3, str4).split(",")[1],	//2 - typ
						str_date.substring(str5 + 1, str6),				//3 - date M
						str_date.substring(str6 + 1, str7),				//4 - date D
						output.substring(str3, str4).split(",")[3],	//5 - user
						output.substring(str3, str4).split(",")[4],	//6 - visits
						output.substring(str3, str4).split(",")[5],	//7 - pins
						output.substring(str3, str4).split(",")[6],	//8 - vote
					];
					output = output.slice(str4 + 1);
					tr = document.createElement("tr");
						tr.setAttribute("class", "entry");
						tr.setAttribute("id", "t" + str_parts[0]);
						td = document.createElement("td");
							td.setAttribute("class", "pic");
						tr.appendChild(td);
						td = document.createElement("td"); //date
							td.setAttribute("class", "info");
							i = document.createElement("i");
								txt = document.createTextNode(str_parts[4]);
								i.appendChild(txt);
								br = document.createElement("br");
								i.appendChild(br);
								txt = document.createTextNode(str_parts[3]);
								i.appendChild(txt);
							td.appendChild(i);
						tr.appendChild(td);
						td = document.createElement("td"); //text
							td.setAttribute("class", "text");
							td.setAttribute("onclick", "topic(" + str_parts[0] + ");");
							txt = document.createTextNode(str_parts[1]);
							td.appendChild(txt);
						tr.appendChild(td);
						td = document.createElement("td"); //User
							td.setAttribute("class", "info");
							txt = document.createTextNode(str_parts[5]);
							td.appendChild(txt);
						tr.appendChild(td);
						td = document.createElement("td"); //stats
							td.setAttribute("class", "info");
							txt = document.createTextNode(0);
							td.appendChild(txt);
							br = document.createElement("br");
							td.appendChild(br);
							txt = document.createTextNode(str_parts[6]);
							td.appendChild(txt);
						tr.appendChild(td);	
						td = document.createElement("td");
							td.setAttribute("class", "info");
							img = document.createElement("img");
								img.setAttribute("src", "http://icons.iconarchive.com/icons/custom-icon-design/pretty-office-8/32/Eye-icon.png");
							td.appendChild(img);
							br = document.createElement("br");
							td.appendChild(br);
							img = document.createElement("img");
								img.setAttribute("src", "http://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/32/Actions-edit-redo-icon.png");
							td.appendChild(img);
						tr.appendChild(td);	
						td = document.createElement("td"); //pins
							td.setAttribute("class", "pins");
							txt = document.createTextNode(str_parts[8]);
							td.appendChild(txt);
						tr.appendChild(td);
					table.appendChild(tr);
				}
			}
			//Neuer Eintrag
			tr = document.createElement("tr");
				tr.setAttribute("class", "entry");
				td = document.createElement("td");
					td.setAttribute("class", "pic");
				tr.appendChild(td);
				td = document.createElement("td"); //date
					td.setAttribute("class", "info");
					i = document.createElement("i");
						var d = new Date();
						txt = document.createTextNode(d.getDate());
						i.appendChild(txt);
						br = document.createElement("br");
						i.appendChild(br);
						txt = document.createTextNode(1 + d.getMonth());
						i.appendChild(txt);
					td.appendChild(i);
				tr.appendChild(td);
				td = document.createElement("td"); //text
					td.setAttribute("class", "text");
					div = document.createElement("div");
						div.setAttribute("style", "margin-right:5px;");
						textarea = document.createElement("textarea");
							textarea.setAttribute("style", "width:100%;height:53px;");
							textarea.setAttribute("maxlength", "300");
							textarea.setAttribute("id","topic_i_" + xmlhttp.forumid);
						div.appendChild(textarea);
						a = document.createElement("a");
							a.innerHTML = "Thema ver�ffentlichen";
							a.setAttribute("class", "button");
							a.setAttribute("onclick","addtopic(" + xmlhttp.forumid + ");");
						div.appendChild(a);
					td.appendChild(div);
				tr.appendChild(td);
				td = document.createElement("td"); //user
					td.setAttribute("class", "info");
					td.innerHTML = "Username";
				tr.appendChild(td);
				td = document.createElement("td"); //stats
					td.setAttribute("class", "info");
					txt = document.createTextNode(0);
					td.appendChild(txt);
					br = document.createElement("br");
					td.appendChild(br);
					txt = document.createTextNode(str_parts[6]);
					td.appendChild(txt);
				tr.appendChild(td);	
				td = document.createElement("td");
					td.setAttribute("class", "info");
					img = document.createElement("img");
						img.setAttribute("src", "http://icons.iconarchive.com/icons/custom-icon-design/pretty-office-8/32/Eye-icon.png");
					td.appendChild(img);
					br = document.createElement("br");
					td.appendChild(br);
					img = document.createElement("img");
						img.setAttribute("src", "http://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/32/Actions-edit-redo-icon.png");
					td.appendChild(img);
				tr.appendChild(td);	
				td = document.createElement("td"); //pins
					td.setAttribute("class", "pins");
					txt = document.createTextNode(str_parts[8]);
					td.appendChild(txt);
				tr.appendChild(td);
			table.appendChild(tr);
		}
	}
	xmlhttp.send(null);
}

function addtopic(id){
	var topic = document.getElementById("topic_i_" + id);
	if(topic.value != ""){
		var url = 'xmlhttp/addtopic.php?id=' + id + '&mes=' + topic.value;
		xmlhttp.forumid = id;
		xmlhttp.open('get', url,false);
		xmlhttp.onreadystatechange = function(){
			if (xmlhttp.readyState == 4 && xmlhttp.status==200){
				forum(xmlhttp.forumid);		
			}
		}
		xmlhttp.send(null);
	}
}

function topic(id){
	var url = 'xmlhttp/gettopic.php?id=' + id;
	xmlhttp.forumid = id;
	xmlhttp.open('get', url,false);
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status==200){
			var str1,str2,str3,str4,str5,str6,str7,str_date,str_parts;
			var output = xmlhttp.responseText;
			var id = xmlhttp.forumid;
			changemenu(9);
			var post = document.getElementById("topic");
			post.innerHTML = "";
			
			//Daten holen
			var topic = document.getElementById("t" + id);
			
			var table, tr, td, i, br, b, th;
			
			table = document.createElement("table");
				/*** Überschrift ***/
				tr = document.createElement("tr");
					tr.setAttribute("class", "header");
					th = document.createElement("th");
						var names = ["Allgemeines"];
						th.innerHTML = names[0];
						th.setAttribute("colspan", "7");
					tr.appendChild(th);
				table.appendChild(tr);
				/*** Topic anzeigen ***/
				tr = document.createElement("tr");
					tr.setAttribute("class", "entry");
					tr.innerHTML = topic.innerHTML;
				table.appendChild(tr);
			post.appendChild(table);
			
			/*** Posts ***/
			table = document.createElement("table");
				/*** Überschrift ***/
				tr = document.createElement("tr");
					tr.setAttribute("class", "header");
					th = document.createElement("th");
						th.innerHTML = "Kommentare";
						th.setAttribute("colspan", "7");
					tr.appendChild(th);
				table.appendChild(tr);
				if(output != 0){
					while (output != ""){
						//id("text",typ,date,user,visits,pins,vote)
						str1 = output.indexOf("(");
						str2 = output.indexOf('"');
						str3 = output.indexOf('"', str2 + 1);
						str4 = output.indexOf(")");
						str_date = output.substring(str3, str4).split(",")[1];
						str5 = str_date.indexOf("-");
						str6 = str_date.indexOf("-", str5 + 1);
						str7 = str_date.indexOf(" ", str6 + 1);
						res = [
							output.substring(0, str1),					//0 - id
							output.substring(str2+1, str3),				//1 - text
							str_date.substring(str5 + 1, str6),				//2 - date M
							str_date.substring(str6 + 1, str7),				//3 - date D
							output.substring(str3, str4).split(",")[2],	//4 - user
						];
						output = output.slice(str4 + 1);
					
						/*** Posts ***/
						tr = document.createElement("tr");
							tr.setAttribute("class", "entry");
							td = document.createElement("td"); //date
								td.setAttribute("class", "info");
								td.innerHTML = "<i>" + res[3] + "<br>" + res[2] + "</i>";
							tr.appendChild(td);
							td = document.createElement("td"); //text
								td.setAttribute("class", "text");
								td.innerHTML = res[1];
							tr.appendChild(td);
							td = document.createElement("td"); //User
								td.setAttribute("class", "info");
								td.innerHTML = "Orasund";
							tr.appendChild(td);
						table.appendChild(tr);
					}
				}
				
				//Neuer Eintrag
				tr = document.createElement("tr");
					tr.setAttribute("class", "entry");
					td = document.createElement("td"); //date
						td.setAttribute("class", "info");
						var d = new Date();
						td.innerHTML = "<i>" + d.getDate() + "<br>" + 1 + d.getMonth() + "</i>";
					tr.appendChild(td);
					td = document.createElement("td"); //text
						td.setAttribute("class", "text");
						div = document.createElement("div");
							div.setAttribute("style", "margin-right:5px;");
							textarea = document.createElement("textarea");
								textarea.setAttribute("style", "width:100%;height:53px;");
								textarea.setAttribute("maxlength", "300");
								textarea.setAttribute("id","post_i");
							div.appendChild(textarea);
							a = document.createElement("a");
								a.innerHTML = "Kommentar abgeben";
								a.setAttribute("class", "button");
								a.setAttribute("onclick","addpost(" + id + ");");
							div.appendChild(a);
						td.appendChild(div);
					tr.appendChild(td);
					td = document.createElement("td"); //User
						td.setAttribute("class", "info");
						td.innerHTML = "Username";
					tr.appendChild(td);
				table.appendChild(tr);
			post.appendChild(table);
		}
	}
	xmlhttp.send(null);
}

function addpost(id){
	var post = document.getElementById("post_i");
	if(post.value != ""){
		var url = 'xmlhttp/addtopic.php?id=' + id + '&typ=' + 1 + '&mes=' + post.value;
		xmlhttp.forumid = id;
		xmlhttp.open('get', url,false);
		xmlhttp.onreadystatechange = function(){
			if (xmlhttp.readyState == 4 && xmlhttp.status==200){
				topic(xmlhttp.forumid);		
			}
		}
		xmlhttp.send(null);
	}
}
