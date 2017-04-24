var shs = false, dt = false, pisca = false, rept = 2;

$(function(){
    $(window).scroll(function () {
        if ($(this).scrollTop() > 258) {
            $("#top").css("bottom","10px");            
        } else {
            $("#top").css("bottom","-70px");
        }
    });
    /*
    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {        	
            $("header").addClass("fix");
            $("div#or").addClass("fix");            
        } else {
            $("header").removeClass("fix");
            $("div#or").removeClass("fix");
        }
    }); */

});

//animacoes do site
$(document).ready(function(){
    $("#submenu ul li img").animate({width:"20px"},0).animate({width:"64px",transform:"rotate(360deg)"},"fast");
});
//fim animacoes do site

$(document).ready(function(){
	$("#cadastro").submit(function(){
		var msg = "",er = 0;
		if($("#i_senha1").val() != $("#i_senha2").val()){
			msg += "Senhas nao coicidem\n";
			er++;
		}
		if($("#i_email1").val() != $("#i_email2").val()){
			msg += "E-mails nao coicidem\n";
			er++;
		}
		if(!TestaCPF(limpaCpf(cadastro.cpf.value))){
			msg += "CPF inválido\n";
			er++;
		}
		if(!isNumero($("#cadastro input#i_num").val())){
			msg += "Numero do endereço inválido\n";
			er++;
		}
		if(er > 0){
			alert("Os seguintes erros foram encontrados:\n\n"+msg);
			return false;
		}
	});
});

$(document).ready(function(){
	$("#shs").click(function(){
		if(!shs){
			$("#i_chave").attr("type","text");	
			$("#shs").css("background","#fff");
			$("#shs").css("color","#8A0000");
			$("#shs").css("width","60px");
			$("#shs").html("esconder");
		}else{
			$("#i_chave").attr('type','password');
			$("#shs").css("background","#8A0000");
			$("#shs").css("color","#fff");
			$("#shs").css("width","55px");
			$("#shs").html("mostrar");
		}
		shs = !shs;
	});
});

$(document).ready(function(){$("#top").click(function(){window.location.href = "#";});});

/* $(document).ready(function(){
	$("article#submenu ul#dist li#1").click(function(){window.location.href = "acesso";});
	$("article#submenu ul#dist li#2").click(function(){window.location.href = "cadastro";});
	$("article#submenu ul#mn li#li_mat").click(function(){window.location.href = "../material";});
	$("article#submenu ul#itens li").click(function(){
		alert("asdasdas");
	});
}); */

$(document).ready(function(){
	$("article#submenu ul li").click(function(){
		var dest = $(this).attr("dest");
		if(dest != null)
			window.location.href = dest;
	});
});

$(document).ready(function(){
	$("article#faq ul.dpd li").click(function(){
		var dest = $(this).attr("dest");
		if(dest != null)
			window.location.href = dest;
		var id = $(this).attr('dest');
		$(id).css("background","rgba(0,240,0,.2)");
		setTimeout(function() {$(id).css("background","none");}, 500);
		setTimeout(function() {$(id).css("background","rgba(0,240,0,.2)");}, 1000);
		setTimeout(function() {$(id).css("background","none");}, 1500);
		setTimeout(function() {$(id).css("background","rgba(0,240,0,.2)");}, 2000);
		setTimeout(function() {$(id).css("background","none");}, 2500);		
	});
});

$(document).ready(function(){
	$("header ul li:last-child").click(function(){
		var xx = $("header ul li:last-child a").html();
		var n = xx.indexOf("sair");
		if(n != -1) return confirm("A sessao será encerrada, voce tem certeza disso?");
	});
});

$(document).ready(function(){
	$("#i_modalidade").change(function(){
		$("form#alunos").submit();
	});
});

$(document).ready(function(){
	$("button#voltar_infoaluno").click(function(){
		window.location.href = "../alunos";
	});
});

$(document).ready(function(){
	$(".errorMsg span").click(function(){
		$(this).parent(".errorMsg").fadeOut(400);
	});
});

$(document).ready(function(){
	$(".errorMsg").click(function(){
		$(this).fadeOut(400);
	});
});

$(document).ready(function(){
	$(".boaMsg span").click(function(){
		$(".boaMsg").fadeOut(400);
	});
});

$(document).ready(function(){
	$(".boaMsg").click(function(){
		$(this).fadeOut(400);
	});
});

$(document).ready(function(){
	$("form#selproj #i_projeto").change(function(){		
		$("form#selproj").submit();
	});
});
/*
$(document).ready(function(){
	$("form input[type='submit']").click(function(){
		$(this).css("background","#eee");
		$(this).css("color","#606060");		
		$(this).css("cursor","default");
	});
});
*/

$(document).ready(function(){
	$("form#evAt fieldset select#select_evAt").change(function(){
		if($("form#evAt fieldset select#select_evAt option:selected").text() != "selecione"){
			$("form#evAt").submit();
		}
	});
});

$(document).ready(function(){
	$("form#evAt input[type='submit']").click(function(){
		if($("form#evAt fieldset select#select_evAt option:selected").text() == "selecione"){
			alert("Selecione uma atividade para submeter!");
			return false;
		}
	});
});

$(document).ready(function(){
    $("input[type='submit']").click(function(){
        if($("select option:selected").val() == "selecione" || $("select option:selected").val() == ""){
            alert("Voce deve selecionar uma opcao para submeter o formulario.");
            return false;
        }
    });
});

/*
$(document).ready(function(){
	$("div#or span:last-child").click(function(){
        var ende = $("div#or").children().eq(-3).attr("href");
        window.location.href = ende;
	});
});
*/

$(document).ready(function(){
	$("form#f_avaliaAtv button#mask_desap").click(function(){
		event.preventDefault();
		$(this).css("display","none");
		$("form#f_avaliaAtv input#i_desaprovar").css("display","inline");
		$("form#f_avaliaAtv label").fadeIn(400);
		$("form#f_avaliaAtv textarea").slideDown(300);
	});
});

$(document).ready(function(){
	$("article#lista_th ul li").click(function(){
		var info = $(this).children(".extra");
		if(info.css("display") == "none"){
			info.slideDown(400);
			$(this).children("span.enf_azul").fadeOut(400);
		}else{
			if(info.css("display") == "block"){
				info.slideUp(400);
				$(this).children("span.enf_azul").delay(400).fadeIn("fast");
			}
		}
	});
});

$(document).ready(function(){
	$("form").submit(function(){
		var op = $("option:selected").val();
		if(op == "selecione" || op == "selecionar"){
			alert("Selecione uma opção no formulario!");
			return false;
		}
	});
});


$(document).ready(function(){
	$("article.grafico ul li").click(function(){
		var li = $(this);
		var obj = $(this).attr("id");
		obj = "#extrahisto"+obj;
		if($(obj).css("display") == "none"){
			li.attr("title","clique sobre para esconder as estatísticas");
			$(obj).slideDown(400);
		}else{
			if($(obj).css("display") == "block"){
				li.attr("title","clique sobre para mostrar as estatísticas");
				$(obj).slideUp(400);
			}
		}
	});
});

$(document).ready(function(){	
	$("input#i_apelido, input#i_titc").keyup(function(){
		var f = $(this).val();
		$("span#infoProjeto span.cor_verde:last-child").text(f);
	});
});

$(document).ready(function(){
	$("form#delTPpr").submit(function(){
		return confirm("Voce tem certeza que vai deletar este tipo de projeto ?");
	})
});

/*
$(document).ready(function(){
	$("span.div_meses").click(function(){
		var bt = $(this);
		if(bt.children('input[type="checkbox"]').prop("checked")){
			bt.css("background","#eeeeee");
			bt.children('input[type="checkbox"]').removeProp("checked");
		}else{
			bt.css("background","#c0c0c0");			
			bt.children('input[type="checkbox"]').prop("checked","checked");
		}
	});
}); */

$(document).ready(function(){
	$("button#bt_addCr").click(function(){
		var implement = '<div class="cronograma_atividade">';
		implement += '<br>';		
		implement += '<textarea name="atividade[]" required class="atividade" cols="30" rows="5"></textarea>';
		implement += '<div class="cronograma_meses">';
		implement += '			<span class="div_meses"><input type="checkbox" name="mes1[]" value="'+rept+'"></span>';
		implement += '			<span class="div_meses"><input type="checkbox" name="mes2[]" value="'+rept+'"></span>';
		implement += '			<span class="div_meses"><input type="checkbox" name="mes3[]" value="'+rept+'"></span>';
		implement += '			<span class="div_meses"><input type="checkbox" name="mes4[]" value="'+rept+'"></span>';
		implement += '			<span class="div_meses"><input type="checkbox" name="mes5[]" value="'+rept+'"></span>';
		implement += '			<span class="div_meses"><input type="checkbox" name="mes6[]" value="'+rept+'"></span>';
		implement += '			<span class="div_meses"><input type="checkbox" name="mes7[]" value="'+rept+'"></span>';
		implement += '			<span class="div_meses"><input type="checkbox" name="mes8[]" value="'+rept+'"></span>';
		implement += '			<span class="div_meses"><input type="checkbox" name="mes9[]" value="'+rept+'"></span>';
		implement += '			<span class="div_meses"><input type="checkbox" name="mes10[]" value="'+rept+'"></span>';
		implement += '			<span class="div_meses"><input type="checkbox" name="mes11[]" value="'+rept+'"></span>';
		implement += '			<span class="div_meses"><input type="checkbox" name="mes12[]" value="'+rept+'"></span>';
		implement += '		</div>';
		implement += '		</div>';
		$("div#delimiter").before(implement);
		rept++;
	});
});

$(document).ready(function(){
	$("button#bt_remCr").click(function(){
		$("fieldset#cronograma_projeto div.cronograma_atividade").last().remove();
	});
});

$(document).ready(function(){
    $("div.next").click(function(){        
        var pos = $(".info_cadastro_progress .ativa").index();
        var pos2 = $(".info_cadastro_progress .ativa").index();
        var ativa = $(".info_cadastro_progress .ativa");
        if(!temInputEmBranco($("fieldset.ativo"))){
            if(pos < 3){
                $("fieldset").removeClass("ativo");
                $("fieldset").eq(pos+1).addClass("ativo");
                $("fieldset.ativo").animate({marginLeft: "800px"},0).animate({marginLeft: "0px"},400);
                
                $(ativa).removeClass("ativa");
                $(ativa).addClass("completa");

                $(ativa).children("span.status").removeClass("andamento");
                $(ativa).children("span.status").addClass("completo");
                $(ativa).children("span.status").text("completo");
                $(ativa).fadeOut().fadeIn(300);

                $(".info_cadastro_progress div").eq(pos2+1).addClass("ativa");
                $(".info_cadastro_progress div").eq(pos2+1).children("span.status").addClass("andamento");
                $(".info_cadastro_progress div").eq(pos2+1).children("span.status").text("em andamento");                
            }else{
                sessionStorage.setItem("confirmouCadastro",true);
                $("form#cadastro").submit();
            }
        }else{
            alert("Preencha todos os campos antes de continuar.");
        }   
    });
});

$(document).ready(function(){
    $(".info_cadastro_progress div").click(function(){
        if($(this).hasClass("completa")){
            var pos = $(this).index();
            $("fieldset").removeClass("ativo");
            $("fieldset").eq(pos).addClass("ativo");
            
            //para cada div antes da clicada, coloca completa
            $(".info_cadastro_progress div").each(function(i){
                if(i < pos){
                    $(this).removeClass("ativa");
                    
                    $(this).children("span.status").removeClass("andamento");
                    $(this).children("span.status").text("completo");
                    
                    $(this).addClass("completa");
                    $(this).children("span.status").addClass("completo");
                }
            });
            
            //remove class da ativa
            $(".info_cadastro_progress div").removeClass("ativa");
            $(".info_cadastro_progress div span.status").removeClass("andamento");
            
            //altera a ativa pra que foi clicada
            $(this).removeClass("completa").addClass("ativa");
            $(this).children("span.status").removeClass("completo").addClass("andamento");
            $(this).children("span.status").text("em andamento");
            
        }
        
    });
});

$(document).ready(function(){
    $("form#f_atacc fieldset select#i_conta").change(function(){
        var cod = $(this).children("option:selected").val();
        $.post("busca_tipoConta.php",{cod : cod,validaBuscaTipo : true},function(data){
            $("#tipo_conta").empty();
            $("#tipo_conta").text(data);            
        });
        $("#tipo_conta").html('<img src="../../_icones/icon_loading.gif" width="30px" alt="carregando" />');
    });
});

$(document).ready(function(){
    $("select[name='tipoR']").change(function(){
        var valor = $(this).children("option:selected").val();        
        $.post("busca_tipoProjeto.php",{cod:valor,validaBusca:true},function(data){
            $("#nomeTipo").empty();
            $("#nomeTipo").text(data);
        });
        $("#nomeTipo").html('<img src="../../_icones/icon_loading.gif" width="30px" alt="carregando" />');
    });
});

$(document).ready(function(){
   $("table.minimenu tr td").click(function(){
       var href = $(this).children("a").attr("href");
       window.location.href = href;
   });
});

var form_p, validou_senha = false;

$(document).ready(function(){
    
    $("#confirma_login form").submit(function(e){e.preventDefault();return 0;});
    
    $("form.p").submit(function(e){
        if(!validou_senha){
            e.preventDefault() ;

            form_p = $(this);

            $("#mask").fadeIn(0);
            $("#confirma_login").css("top","-50%").fadeIn(400).animate({"top":"35%"},"fast");
        }
        
        validou_senha = false;

        return 0;
    });
    
    $("#confirma_login #altera").click(function(){
        var s = $("#input_confirma_login").val(),
            t = $(form_p).children("input[type='submit']").attr("name"),
            inn = '<input type="hidden" name="a_senha" value="'+s+'" />',
            ttp = '<input type="hidden" name="'+t+'" />';

        if(s.length > 0){
            validou_senha = true;
            $(form_p).append(inn);
            $(form_p).append(ttp);
            $(form_p).submit();
        }
    });
    
    $("#confirma_login #naoaltera").click(function(){
        $("#confirma_login").fadeOut(300);
        $("#mask").fadeOut(300);
    });

});

$(document).ready(function(){
    $("#editacoord").click(function(e){
        e.preventDefault();
        
        $(".mask").show();
        $(".lista#lista-coord").fadeIn(200);
        
        return 0;
    });
    
    $("#botao-lista-coord").click(function(e){
        e.preventDefault();
        
        $(".lista#lista-coord").hide();
        $(".mask").fadeOut(200);
        
        return 0;
    });
    
    $(".lista ul li").click(function(){
        if($(this).index() != 0){
            var id = $(this).attr("id"),
                nome = $(this).text()
            id = id.split("-");
            $("form fieldset #i_idcoord").val(id[2]);
            $("form fieldset #i_coord").val(nome);
            
            $(".lista").hide();
            $(".mask").fadeOut(200);
        }
    });
    
    $(".mask").click(function(){
        /* o que some antes */
        $(".lista").hide();
        /* ---------------- */
        $(this).fadeOut(200);
    });
    
});

/* pegando endereço pelo cep */

$(document).ready(function(){
    $("form fieldset input#i_cep").keyup(function(e){
        var cep = $(this).val();
        if(cep.length >= 8){
            cep = 'http://viacep.com.br/ws/'+cep+'/xml';
            $.ajax({
                    url:cep,
                    success:function(data){
                        $(data).find('xmlcep').each(function(){
                            var log = $(this).find('logradouro').text(),
                                comp = $(this).find('complemento').text().length > 0 ? $(this).find('complemento').text() : 'Nenhum',
                                bairro = $(this).find('bairro').text();
                            $("form fieldset input#i_logradouro").val(log)
                            $("form fieldset input#i_comp").val(comp);
                            $("form fieldset input#i_bairro").val(bairro);
                            
                            $("form fieldset input#i_num").focus();
                        });
                    },
                    dataType:'xml'
            });
        }
        
    });
});

/* funcoes function */

function TestaCPF(strCPF) { var Soma; var Resto; Soma = 0; if (strCPF == "00000000000") return false; for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i); Resto = (Soma * 10) % 11; if ((Resto == 10) || (Resto == 11)) Resto = 0; if (Resto != parseInt(strCPF.substring(9, 10)) ) return false; Soma = 0; for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i); Resto = (Soma * 10) % 11; if ((Resto == 10) || (Resto == 11)) Resto = 0; if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false; return true; }

function isNumero(valor) {
	var regra = /^[0-9]+$/;
	if (valor.match(regra)) {
		return true;
	}else{
		return false;
	}
};

function piscar(){
	if(pisca){
		$("article#submenu ul#itens li span.indice").css("background","#8A0000");
		$("article#submenu ul#itens li span.indice").css("color","#fff");
	}else{
		$("article#submenu ul#itens li span.indice").css("background","#ddd");
		$("article#submenu ul#itens li span.indice").css("color","#606060");
	}
	setTimeout(piscar, 300);
	pisca = !pisca;
}

function urlAbre(u){window.location.href=u;}

function limpaCpf(cpf){
	var c = 0, tam = cpf.length;
	for(c = 0; c < tam;c++){
		if(cpf.substring(c,c+1) === "." || cpf.substring(c,c+1) === "-" ){
			cpf = cpf.replace(cpf.substring(c,c+1),'');
		}
		tam = cpf.length;
	}
	return cpf;
}

function temInputEmBranco(field){
    
    var vazio=0;
    
    $(field).children("div").each(function(i){
        $(this).children("input").each(function(c){
            if(!$(this).val().length){
                vazio ++;
            }
        });
    });
    
    if(vazio == 0)
        return 0;
    else
        return 1;    
    
}