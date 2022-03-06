<?php 
 use app\models\Historico;
 use app\models\Historicodedisparos as Disparosh;
?>
<style>
    .tracking-detail {
    padding:3rem 0
    }
    #tracking {
    margin-bottom:1rem
    }
    [class*=tracking-status-] p {
    margin:0;
    font-size:1.1rem;
    color:#fff;
    text-transform:uppercase;
    text-align:center
    }
    [class*=tracking-status-] {
    padding:1.6rem 0
    }
    .tracking-status-intransit {
    background-color:#65aee0
    }
    .tracking-status-outfordelivery {
    background-color:#f5a551
    }
    .tracking-status-deliveryoffice {
    background-color:#f7dc6f
    }
    .tracking-status-delivered {
    background-color:#4cbb87
    }
    .tracking-status-attemptfail {
    background-color:#b789c7
    }
    .tracking-status-error,.tracking-status-exception {
    background-color:#d26759
    }
    .tracking-status-expired {
    background-color:#616e7d
    }
    .tracking-status-pending {
    background-color:#ccc
    }
    .tracking-status-inforeceived {
    background-color:#214977
    }
    .tracking-list {
    border:1px solid #e5e5e5
    }
    .tracking-item {
    border-left:1px solid #e5e5e5;
    position:relative;
    padding:2rem 1.5rem .5rem 2.5rem;
    font-size:.9rem;
    margin-left:3rem;
    min-height:5rem
    }
    .tracking-item:last-child {
    padding-bottom:4rem
    }
    .tracking-item .tracking-date {
    margin-bottom:.5rem
    }
    .tracking-item .tracking-date span {
    color:#888;
    font-size:85%;
    padding-left:.4rem
    }
    .tracking-item .tracking-content {
    padding:.5rem .8rem;
    background-color:#f4f4f4;
    border-radius:.5rem
    }
    .tracking-item .tracking-content span {
    display:block;
    color:#888;
    font-size:85%
    }
    .tracking-item .tracking-icon {
    line-height:2.6rem;
    position:absolute;
    left:-1.3rem;
    width:2.6rem;
    height:2.6rem;
    text-align:center;
    border-radius:50%;
    font-size:1.1rem;
    background-color:#fff;
    color:#fff
    }
    .tracking-item .tracking-icon.status-sponsored {
    background-color:#f68
    }
    .tracking-item .tracking-icon.status-delivered {
    background-color:#4cbb87
    }
    .tracking-item .tracking-icon.status-outfordelivery {
    background-color:#f5a551
    }
    .tracking-item .tracking-icon.status-deliveryoffice {
    background-color:#f7dc6f
    }
    .tracking-item .tracking-icon.status-attemptfail {
    background-color:#b789c7
    }
    .tracking-item .tracking-icon.status-exception {
    background-color:#d26759
    }
    .tracking-item .tracking-icon.status-inforeceived {
    background-color:#214977
    }
    .tracking-item .tracking-icon.status-intransit {
    color:#e5e5e5;
    border:1px solid #e5e5e5;
    font-size:.6rem
    }
    @media(min-width:992px) {
    .tracking-item {
    margin-left:10rem
    }
    .tracking-item .tracking-date {
    position:absolute;
    left:-10rem;
    width:7.5rem;
    text-align:right
    }
    .tracking-item .tracking-date span {
    display:block
    }
    .tracking-item .tracking-content {
    padding:0;
    background-color:transparent
    }
    }
</style>
<div class="row" style="background-color: white !important;">
    <div class="col-md-6 col-lg-6">
        <br>
        <h3>Histórico de Disparos de Mensagens</h3>
        <hr>
        <div id="tracking-pre"></div>
            <div id="tracking">
            <div class="tracking-list">
                <?php
                    $disparosh = Disparosh::find()->where(['proposta_id' => $model->id])->orderBy(['data'=>SORT_DESC])->all();
                    foreach ($disparosh as $key => $row) {
                        $row_data = date('d/m/Y - H:i:s', strtotime($row->data ));
                        $icone = 'fas fa-clock';
                        if ($row->modo == 'whats') {
                            $icone = 'fa fa-whatsapp';
                        } else {
                            $icone = 'fa fa-envelope-o';
                        }
                        echo "<!-- Item --> 
                        <div class='tracking-item'>
                            <div class='tracking-icon status-outfordelivery' style='background-color: green'>
                                <i class='$icone' style='font-size: 16px;text-align: center;padding: 17%;'></i>
                            </div>
                            <div class='tracking-date'>{$row_data} [{$row->modo}] por {$row->usuario->nome}</div>
                            <div class='tracking-content'>
                                <h3 class='title'>Etapa: {$row->etapa}</h3>
                                <p class='description''>
                                ".utf8_decode($row->mensagem)."
                                </p>
                            </div>
                        </div>";
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6">
        <br>
        <h3>Histórico de Atividades</h3>
        <hr>
        <div id="tracking-pre"></div>
            <div id="tracking">
            <div class="tracking-list">
                <?php
                    $historico = Historico::find()->where(['id_referencia' => $pretendente_id])->orderBy(['data'=>SORT_DESC])->all();
                    foreach ($historico as $key => $row) {
                        $row_data = date('d/m/Y - H:i:s', strtotime($row->data ));
                        echo "<!-- Item --> 
                        <div class='tracking-item'>
                            <div class='tracking-icon status-outfordelivery'>
                                <i class='fas fa-clock' style='font-size: 22px;padding: 9%;'></i>
                            </div>
                            <div class='tracking-date'>{$row_data}</div>
                            <div class='tracking-content'>
                                <h3 class='title'>{$row->atividade}</h3>
                                <p class='description''>
                                {$row->descricao}
                                </p>
                            </div>
                        </div>";
                    }
                ?>
            </div>
        </div>
    </div>
</div>