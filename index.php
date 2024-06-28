<?php 
include('admin/config.php');

if (!isset($_SESSION['usu_tipo'])) {
    header('Location: acceder.php');
}

// Llamado General
$sql = "SELECT * FROM publicaciones P LEFT JOIN usuarios U ON P.usuarios_id = U.usuarios_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Llamado Descripción
for ($i=0; $i < count($data); $i++) {

    $data[$i]['pub_descripcion'] = '<b>'.$data[$i]['pub_descripcion'].'</b>';

    $sql = "SELECT * FROM publicaciones_carreras P LEFT JOIN carreras C ON P.carreras_id = C.carreras_id WHERE P.publicaciones_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$data[$i]['publicaciones_id']]);
    $pcarreras = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data[$i]['pub_descripcion'] .= (count($pcarreras) == 1) ? '<br>Llamado a la carrera:<br>' : '<br>Llamado a las carreras:<br>';
    
    // Loop por cada carrera
    $carreras = array();
    for ($x=0; $x < count($pcarreras); $x++) {
        $sql = "SELECT * FROM publicaciones_carreras_anios P WHERE P.publicaciones_carreras_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$pcarreras[$x]['publicaciones_carreras_id']]);
        $panios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $anios = '';
        for ($z=0; $z < count($panios); $z++) {
            $txt = '';
            if (count($panios) == $pcarreras[$x]['car_duracion']) {
                $anios = 'Todos los años';
            } else {
                if ($z == count($panios)-1) {
                    $txt .= ' y ';
                }
                switch ($panios[$z]['pubcarani_anio']) {
                    case '1':
                        $txt .= 'Primer';
                        break;
                    case '2':
                        $txt .= 'Segundo';
                        break;
                    case '3':
                        $txt .= 'Tercer';
                        break;
                    case '4':
                        $txt .= 'Cuarto';
                        break;
                    case '5':
                        $txt .= 'Quinto';
                        break;
                    case '6':
                        $txt .= 'Sexto';
                        break;
                    case '7':
                        $txt .= 'Septimo';
                        break;
                }
                $txt = ($z != 0) ? strtolower($txt) : $txt;

                if ($z == count($panios)-1) {
                    $anios .= $txt.' año';
                } else {
                    $anios .= $txt.', ';
                }
            }
        }

        $data[$i]['pub_descripcion'] .= ' - ' . $pcarreras[$x]['car_nombre'] . ': ' . $anios;
        if ($z != count($panios)-1) {
            $data[$i]['pub_descripcion'] .= '<br>';
        }
        $carreras[] = $pcarreras[$x]['carreras_id'];
    }
    $data[$i]['array_carreras'] = $carreras;
}

// si hay filtro de carrera
if(!empty($_GET['carrera'])) {
    $tmp = array();
    for ($i=0; $i < count($data); $i++) { 
        if (in_array($_GET['carrera'],$data[$i]['array_carreras'])) {
            $tmp[] = $data[$i];
        }
    }
    $data = $tmp;
}


// filtro de categorias
$sql = "SELECT * FROM carreras WHERE car_activo = 'A'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);

$css1 = "index.css";
$title = "Actividades Universitarias";
include('views/index.view.php');
?>