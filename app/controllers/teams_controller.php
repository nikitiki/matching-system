<?php
/**
 * �`�[���o�^
 *
 */
class TeamsController extends AppController {

    // �e���v���[�g�ݒ�
    var $layout = 'default';

    // ���f���ݒ�
    var $use = array( 'team', 'prefecture' );

    // �w���p�[��`
    var $helper = array( 'prefecture' );

    // {{{ index
    /**
     * �`�[���ꗗ���
     */
    public function index() {

        // �`�[���ꗗ�擾
        $teams =  $this->team->find();

var_dump( $teams );

    }
    // }}}


    // {{{ add
    /**
     * �`�[���o�^�t�H�[�����
     */
    public function add() {

        // �e���v���[�g�ݒ�
        $this->setTemplate( 'nologin' );

        // �J�������擾 ���e���v���[�g�ϐ�������
        $this->request->set( 'data', $this->team->schema() );

    }
    // }}}
    

    // {{{ create
    /**
     * �`�[���o�^
     */
    public function create() {


        // �e���v���[�g�ݒ�
        $this->setTemplate( 'nologin' );

        // ���M�{�^���őJ�ڂ��Ă��Ȃ��ꍇ�o�^��ʂɑJ�ڂ�����
        if( empty( $this->request->data ) ) {
            $this->render( array( 'action' => 'add' ) );
            return;
        }

        // �s�v�����폜
        $this->request->data['team']['login_id'] = trim( preg_replace('/[\x00\x1f:<>&%,;]+/', '', $this->request->data['team']['login_id'] ) );
        $this->request->data['team']['email'] = trim( preg_replace( '/[\x00\x1f:<>&%,;]+/', '', $this->request->data['team']['email'] ) );


        // �o���f�[�V�������s
        if( !$res = $this->team->validate( $this->request->data ) ) {

            // �G���[���b�Z�[�W�擾
            $error_msgs = $this->team->err_msg;

            // �G���[���b�Z�[�W�Z�b�g
            $this->request->set( 'error_msgs', $error_msgs );

            // ���͉�ʂɖ߂�
            $this->render( array( 'action' =>  'add' ) );

            // ���͒l���Z�b�g
            $this->request->set( 'data', $this->request->data['team'] );

        } else {

            // �ۑ�����
            $id = $this->team->insert( $this->request->data );

            // ���[�����M����
            $_ = $this->team->sendVerificationEmail( $id, $this->util->getHostInfo() );

            // ����ɏ����I�������烊�_�C���N�g
            $this->util->redirect( '/root/index' );

        }
    }
    // }}}
}
?>
