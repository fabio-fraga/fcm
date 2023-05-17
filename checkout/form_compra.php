
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Checkout </title>
    <style>
        body{
            font-size: Arial,Helvetica,sans-serif;

        }
        </style>
        <link rel="Fim" type="text/css" href="Fim.css" media="screen"/>
</head>
<body>    
<h1>Finalizar Compra</h1>
    <form action="url_para_enviar_dados_do_formulario"method="POST">
        <fieldset>
            <h2>1 Endereço de Entrega</h2>
            <div class ="input_duplo">
        <div>
        <label form action ="nome">Nome:<span>*</span></label>
        <input type="text" name="nome" id ="nome" placeholder="Seu Nome">
        </div>                   
        </div>
        <div>
        <label form action="sobrenome">Sobrenome:<span>*</span></label>
        <input type="text" name="sobrenome" id ="sobrenome" placeholder="Seu Sobrenome">
        </div>
        <div class = "input_simples">
        <label form action="endereço">Endereço:<span>*</span></label>
        <input type="text" name="endereço" id ="endereço" placeholder="Endereço de entrega">
        <div class ="input_duplo">
        <div>
        <label form action ="Cidade">Cidade:<span>*</span></label>
        <input type="text" name="cidade" id ="cidade">
        </div>       
         <form action="cid.php" method="GET">
    <select name="cidade" id="cidade">
        <option>Selecione</option>
        <option value="Estado">AC</option>
        <option value="Estado">AL</option>   
        <option value="Estado">AP</option>      
        <option value="Estado">AM</option>
        <option value="Estado">BA</option>
        <option value="Estado">CE</option>
        <option value="Estado">DF</option>
        <option value="Estado">ES</option>
        <option value="Estado">GO</option>   
        <option value="Estado">MA</option>      
        <option value="Estado">MT</option>
        <option value="Estado">MS</option>
        <option value="Estado">MG</option>
        <option value="Estado">PA</option>
        <option value="Estado">PB</option>
        <option value="Estado">PR</option>   
        <option value="Estado">PE</option>      
        <option value="Estado">PI</option>
        <option value="Estado">RN</option>
        <option value="Estado">RS</option>
        <option value="Estado">RO</option>
        <option value="Estado">RR</option>   
        <option value="Estado">SC</option>      
        <option value="Estado">SP</option>
        <option value="Estado">SE</option>
        <option value="Estado">TO</option>
        <option>
        </option>
    </select>
  <input type="submit" name="submit" id="submit" class="botao" value="Ok">
</form>           
        <div>
        <label form action="cep">CEP:</label>
        <input type="text" name="cep" id ="cep" placeholder="Cep">
        </div>

        <h2>2 Forma de Pagamento</h2>

        <div class ="input_duplo">
        <div class ="radio">
        <input type="radio" name="Cartões de Crédito" id ="Banco do Brasil Gold Visa" value="Banco do Brasil Gold Visa" >
        <label form ="banco do brasil gold visa">Banco do Brasil Gold Visa</label>
        <br>
        <div>
        <img src="https://www.svgrepo.com/download/483086/credit-card.svg"svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	 width="30px" height="60px" viewBox="0 0 512 512"  xml:space="preserve"><a href="">Adicione outro cartão</a>
       </div>

        <div class ="radio">
        <input type="radio" name="Boleto" id ="Boleto" value="Boleto" >
        <label form ="boleto">Boleto</label>
        <br>     
           <img src="https://www.svgrepo.com/download/500331/barcode.svg"svg fill="#000000" width="30px" height="60px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M0 2.53h2.49v10.95H0zm11 0h2.49v10.95H11zm-6.02 0h1.24v10.95H4.98zm2.49 0h1.24v10.95H7.47zm7.29 0H16v10.95h-1.24z"/></svg>
          <br> Vencimento em 3 dias úteis. A data de entrega será alterada devido ao tempo de processametodo boleto.Veja mais na próxima página</br>
        </div>

        <div class ="radio">
        <input type="radio" name="Pix" id ="Pix" value= "Pix" >
        <label form ="pix">Pix</label>
        <div>
        <img src="https://www.svgrepo.com/download/500416/pix.svg"svg fill="#10b7a3" width="30px" height="60px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" stroke="#10b7a3" stroke-width="0.33599999999999997">
        <br> O código Pix gerado para o pagamento é valido por 30 minutos após a finalização do pedido.</br>
<br>

        </div>
        <button>Finalizar Compra</button>
        </fieldset>
        
            </form>
        </div>
    