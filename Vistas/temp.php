<div class="" id="centrar">
    <div class="row"  >
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Payment Details
                    </h3>

                </div>
                <div class="panel-body">
                    <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"> <!-- inicio del formulario -->
                    <div class="form-group">
                        <label for="cardNumber">
                            CARD NUMBER</label>
                        <div class="input-group">
                            <input type="number" class="form-control" minlength="13" required name="numero_tarjeta" id="cardNumber" placeholder="Valid Card Number"
                                required autofocus />
                            
                        </div>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-7 col-md-7">
                            <div class="form-group">
                                <label for="expityMonth">
                                    EXPIRY DATE</label>
                                <div class="">
                                    <input type="number" name="expiry_date1" required class="form-control" maxlenght="2" id="expityMonth" placeholder="MM" required />
                                </div>
                                <div class="">
                                    <input type="number" name="expiry_date2" required class="form-control" maxlenght="2" id="expityYear" placeholder="YY" required /></div>
                            </div>
                        </div>
                        <div class="col-xs-5 col-md-5 pull-right">
                            <div class="form-group">
                                <label for="cvCode">
                                    CV CODE</label>
                                <input type="password" name="cv_code" required class="form-control" id="cvCode" placeholder="CV" required />
                            </div>
                        </div>
                    </div>
                    <input type=hidden name="total" value="<?php echo array_sum($_SESSION['total']); ?>">
                    <input type=hidden name="email_usuario" value="<?php echo $_SESSION['USUARIO']['email'][0]; ?>">
                    <a href="/games/Vistas/carrito.php" class="w3-btn w3-white w3-border w3-border-green w3-round-large" style="text-decoration:none">Volver</a>
                    <button class="w3-btn w3-black w3-border w3-border-black w3-round-large">Total: <?php echo array_sum($_SESSION['total']); ?> €</button>
                    <input type="submit" name="continuar" value="Continuar" class="w3-btn w3-green w3-border w3-border-green w3-round-large" >
                    </form><!-- fin del formulario -->
                </div>
            </div>
        </div>
    </div>
</div>


<div>
    <div class="" id="center" style="width:35%">
    <form  role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="cardNumber">CARD NUMBER</label>
        <input type="number" class="" minlength="13" required name="numero_tarjeta" id="cardNumber" placeholder="Valid Card Number" required autofocus /><br><br>
        <label for="expityMonth">EXPIRY DATE</label><br>
        <input type="number" name="expiry_date1" required class="" maxlenght="2" id="expityMonth" placeholder="MM" required /><br>
        <input type="number" name="expiry_date2" required class="" maxlenght="2" id="expityYear" placeholder="YY" required /><br><br>

        <label for="cvCode">CV CODE</label>
        <input type="password" name="cv_code" required class="" id="cvCode" placeholder="CV" required /> <br><br>                           

        <input type=hidden name="total" value="<?php echo array_sum($_SESSION['total']); ?>">
        <input type=hidden name="email_usuario" value="<?php echo $_SESSION['USUARIO']['email'][0]; ?>">
        <a href="/games/Vistas/carrito.php" class="w3-btn w3-white w3-border w3-border-green w3-round-large" style="text-decoration:none">Volver</a>
        <button class="w3-btn w3-black w3-border w3-border-black w3-round-large">Total: <?php echo array_sum($_SESSION['total']); ?> €</button>
        <input type="submit" name="continuar" value="Continuar" class="w3-btn w3-green w3-border w3-border-green w3-round-large" >               
    </form>
</div>
</div>