<?php require_once('./php/requires.php'); ?>
<?php 
/**
 * Esta es una página temporal de muestra que ejemplifica el email que el usuario recibiría
 * al intentar recuperar su contraseña.
 * 
 * El template fue tomado de MailChimp.
**/
if (isLoggedIn()) 
{
	header('location: index.php');
	exit;
}

$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];
$url .= $_SERVER['REQUEST_URI'];
$url = dirname($url) . '/';

$token = $_GET['token'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <!-- Facebook sharing information tags -->
        <meta property="og:title" content="*|MC:SUBJECT|*" />

        <title>Recuperaci&oacute;n de contraseña</title>

        <style type="text/css">
            /* Client-specific Styles */
            #outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
            body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
            body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */

            /* Reset Styles */
            body{margin:0; padding:0;}
            img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
            table td{border-collapse:collapse;}
            #backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}

            /* Template Styles */

            /* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: COMMON PAGE ELEMENTS /\/\/\/\/\/\/\/\/\/\ */

            /**
            * @tab Page
            * @section background color
            * @tip Set the background color for your email. You may want to choose one that matches your company's branding.
            * @theme page
            */
            body, #backgroundTable{
                /*@editable*/ background-color:#FAFAFA;
            }

            /**
            * @tab Page
            * @section email border
            * @tip Set the border for your email.
            */
            #templateContainer{
                /*@editable*/ border: 1px solid #DDDDDD;
            }

            /**
            * @tab Page
            * @section heading 3
            * @tip Set the styling for all third-level headings in your emails.
            * @style heading 3
            */
            h3, .h3{
                /*@editable*/ color:#202020;
                display:block;
                /*@editable*/ font-family:Arial;
                /*@editable*/ font-size:26px;
                /*@editable*/ font-weight:bold;
                /*@editable*/ line-height:100%;
                margin-top:0;
                margin-right:0;
                margin-bottom:10px;
                margin-left:0;
                /*@editable*/ text-align:left;
            }

            /**
            * @tab Page
            * @section heading 4
            * @tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
            * @style heading 4
            */
            h4, .h4{
                /*@editable*/ color:#202020;
                display:block;
                /*@editable*/ font-family:Arial;
                /*@editable*/ font-size:22px;
                /*@editable*/ font-weight:bold;
                /*@editable*/ line-height:100%;
                margin-top:0;
                margin-right:0;
                margin-bottom:10px;
                margin-left:0;
                /*@editable*/ text-align:left;
            }

            /* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: PREHEADER /\/\/\/\/\/\/\/\/\/\ */

            /**
            * @tab Header
            * @section preheader style
            */
            #templatePreheader{
                /*@editable*/ background-color:#FAFAFA;
            }

            /**
            * @tab Header
            */
            .preheaderContent div{
                /*@editable*/ color:#505050;
                /*@editable*/ font-family:Arial;
                /*@editable*/ font-size:10px;
                /*@editable*/ line-height:100%;
                /*@editable*/ text-align:left;
            }

            /* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: HEADER /\/\/\/\/\/\/\/\/\/\ */

            /**
            * @tab Header
            */
            #templateHeader{
                /*@editable*/ background-color:#FFFFFF;
                /*@editable*/ border-bottom:0;
            }

            #headerImage{
                height:auto;
                max-width:600px;
            }

            /* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: MAIN BODY /\/\/\/\/\/\/\/\/\/\ */

            /**
            * @tab Body
            * @section body style
            */
            #templateContainer, .bodyContent{
                /*@editable*/ background-color:#FFFFFF;
            }

            /**
            * @tab Body
            * @section body text
            */
            .bodyContent div{
                /*@editable*/ color:#505050;
                /*@editable*/ font-family:Arial;
                /*@editable*/ font-size:14px;
                /*@editable*/ line-height:150%;
                /*@editable*/ text-align:left;
            }

            /**
            * @tab Body
            * @section body link
            */
            .bodyContent div a:link, .bodyContent div a:visited, /* Yahoo! Mail Override */ .bodyContent div a .yshortcuts /* Yahoo! Mail Override */{
                /*@editable*/ color:#336699;
                /*@editable*/ font-weight:normal;
                /*@editable*/ text-decoration:underline;
            }

            /* BOT? */
            .ir_al_sitio{
                display:inline-block;
                /*width:120px;*/
                padding:8px;
                color:#ffffff !important;
                font-size:18px;
                text-align:center;
                text-decoration:none !important;
                text-shadow:rgba(0,0,0,0.25) 0 1px 0;
                background:#FD9F01;
                border:solid 1px #cc8100;
                -moz-border-radius:5px;
                -webkit-border-radius:5px;
                border-radius:5px;
            }
            .ir_al_sitio:hover{
                background:#fc9003;
                text-shadow:rgba(0,0,0,0.5) 0 1px 1px;
            }
        </style>
    </head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <center>
            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
                <tr>
                    <td align="center" valign="top">
                        <!-- // Begin Template Preheader \\ -->
                        <table border="0" cellpadding="10" cellspacing="0" width="600" id="templatePreheader">
                            <tr>
                                <td valign="top" class="preheaderContent">
                                    <!-- // Begin Module: Standard Preheader \ -->
                                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                        <tr>
                                            <td valign="top">
                                                <div mc:edit="std_preheader_content">
                                                    Recuperaci&oacute;n de contrase&ntilde;a
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Module: Standard Preheader \ -->
                                </td>
                            </tr>
                        </table>


                        <!-- // End Template Preheader \\ -->
                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                            <tr>
                                <td align="center" valign="top">
                                    <!-- // Begin Template Header \\ -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader">
                                        <tr>
                                            <td class="headerContent">
                                                <!-- // Begin Module: Standard Header Image \\ -->
                                                <img src="./img/email-header.jpg" style="max-width:600px;" id="headerImage campaign-icon" mc:label="header_image" mc:edit="header_image" mc:allowdesigner mc:allowtext />
                                                <!-- // End Module: Standard Header Image \\ -->

                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Header \\ -->

                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- // Begin Template Body \\ -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                        <tr>
                                            <td valign="top" class="bodyContent">
                                                <!-- // Begin Module: Standard Content \\ -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top">
                                                            <div mc:edit="std_content00">
																<h4 class="h4">Recuperaci&oacute;n de contrase&ntilde;a:</h4>
																<br />
																Has solicitado reiniciar tu contrase&ntilde;a desde <strong>OfficeGur&uacute;</strong>.
																<br />
																<br />
																<a class="ir_al_sitio" href="recover-password.php?token=<?php echo $token ?>">Hac&eacute; click ac&aacute; para cambiarla</a>
																<br />
																<br />
																Si el enlace no funciona, por favor copi&aacute; y pegu&aacute; la siguiente direcci&oacute;n en tu navegador:<br> <?php echo $url ?>recover-password.php?token=<?php echo $token ?>
																<br />
																<br />
																Muchas Gracias.
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // End Module: Standard Content \\ -->
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Body \\ -->
                                </td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>