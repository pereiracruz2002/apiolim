<?php Include_once(dirname(__FILE__) . '/header.php'); ?>		
<!-- section4 -->
<tr>
    <td>	
        <table bgcolor="#ffffff" align="center" width="600" style="border-spacing: 0;">
            <tbody>
                <tr style="height:25px;"><td></td></tr>
                <tr align="center">
                    <td style="font:17px Arial, Helvetica, sans-serif;">Bem vindo ao Dinner 4 Friends</td>
                </tr>
                <tr style="height:15px;"><td></td></tr>
                <tr align="center" style="padding-top: 10px;">
                    <td style="font:12px Arial, Helvetica, sans-serif; padding:0 50px 20px;">
                        <p>Obrigado por se cadastrar, estamos ansiosos para ver seus eventos!</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<!-- end section4 -->

<!-- section5 -->
<tr align="center">
    <td>	
        <table bgcolor="#fafafa" align="center" width="600" style="padding:15px 0; border-bottom: 1px solid #eee;">
            <tbody>
                <tr align="center">
                    <td style="font:22px Arial, Helvetica, sans-serif;" class="skin-font">Dados de Acesso</td>
                </tr>
                <tr style="padding-top: 10px;">
                    <td style="font:12px Arial, Helvetica, sans-serif; padding:10px 50px 10px;">
                        <p>Email: <strong><?php echo $email ?></strong></p>
                        <p>Senha: <strong>***</strong></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<!-- end section5 -->


<!-- section6 -->
<tr align="center">
    <td align="left" valign="top">
        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="padding:25px 0; border:1px solid #eee;">
            <tbody>
                <tr>
                    <td align="left" valign="top">
                        <table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top"><img src="<?php echo SITE_URL ?>assets/img/email_template/chef.png" width="120" alt="" style="display:block;" /></td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                        <table width="280" border="0" align="right" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top" style="padding:0px 0px 08px 0px;"></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" style="font:Normal 18px Arial, Helvetica, sans-serif; color:#353333;">Quero ser um Chef</td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" style="font:Normal 12px Arial, Helvetica, sans-serif; color:#858485; line-height:22px; padding-top:4px;">Crie seu eventos e convide seus amigos para participar do Dinner.</td>
                                </tr>
                                <tr>
                                    <td align="left" valign="middle">
                                        <table width="200" border="0" align="left" cellpadding="0" cellspacing="0" style="padding: 12px 20px 12px 0;">
                                            <tbody>											
                                                <tr>
                                                    <td width="70" valign="middle" class="email-btn skin-color">
                                                        <a href="<?php echo SITE_URL ?>" class="btn-inner">
                                                            Me tornar um chef
                                                        </a>											
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<!-- end section6 -->
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>
