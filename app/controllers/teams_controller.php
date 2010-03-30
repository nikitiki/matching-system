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
        $this->request->set( 'teams', $this->team->find() );
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
            if( !$res = $this->team->sendVerificationEmail( $id, $this->util->getHostInfo() ) ) {
                trigger_error( '���[�����M���s���܂���', E_USER_ERROR );
            } 

            // ����ɏ����I�������烊�_�C���N�g
            $this->util->redirect( '/root/index' );

        }
    }
    // }}}

    // {{{ verifiAccount
    /**
     *
     */
    public function verifyAccount() {

        // �R�[�h�ƃ��O�C��ID�̃n�b�V�����擾
        $code = $this->request->getParam( 'code' );
        $login_id_hash = $this->request->getParam( 'l' );

        // ���[�U�����݂��邩�m�F
        if( $user = $this->team->find( 
            array( ':code' => $code ), 'WHERE code = :code' ) ) {

            $user['team'] = $user[0];
            $user_login_id_hash = MD5( $user['team']['login_id'] );

            // �A�N�e�B�x�[�g����Ă��Ȃ���
            if( $login_id_hash == $user_login_id_hash 
               && $user['team']['active_flg'] == false ) {

                // �A�N�e�B�x�[�g����
                $this->team->update( $user );

                // �A�N�e�B�x�[�g������ʂɑJ��
                return;
            } 
        }
        // �G���[��ʂɑJ��
        $this->render( array( 'action' => 'verifyError' ) );
    }
    // }}}


    //{{{ login
    /**
     * ���O�C�����
     */
    public function login() {

        // �I�[�g���O�C���`�F�b�N
        if( false ) {

            // �g�b�v��ʂփ��_�C���N�g
            $this->util->redirect( '/' );
        }

        // GET��
        if( !isset( $this->request->data['team'] ) ) {

            $this->request->set( 'data', $this->team->schema() );

        // POST��
        } else {

/*
            if( isset( $_COOKIE['remember_me'] ) && !is_null( $_COOKIE['remember_me'] ) ) {

                // �I�[�g���O�C����OK�Ȃ�N�b�L�[�̃^�C�����X�V
                $this->auth->_enableRememberMe();

                // �g�b�v�փ��_�C���N�g
                $this->util->redirect( '/' );

            // ���O�C���`�F�b�N
            } else {
*/
              // ���O�C��ID�ƃp�X���[�h��DB�₢���킹
            if( $res =  $this->team->authenticate( $this->request->data ) ) {

                if( $remember_me = $this->request->getParam( 'remember_me' ) ) {
                    $this->auth->_enableRememberMe();
                }

                // �Z�b�V�������Ƀ��[�U�[ID�i�[
                $this->session->add( 'team', $res[0] );

                // �Z�b�V�����t���O�L��
                $this->session->add( 'is_login', 1 );

                // ���_�C���N�g����
                $this->util->redirect( '/root/index' );

            }

            // ���O�C�����s�����t���b�V���Z�b�g
            // �G���[���b�Z�[�W�擾
            $error_msgs = $this->team->err_msg;

            // �G���[���b�Z�[�W�Z�b�g
            $this->request->set( 'error_msgs', $error_msgs );


            $this->request->set( 'data', $this->request->data['team'] );

        }
    }
    // }}}


    // {{{
    /**
     *
     */
    public function logout() {

        // �N�b�L�[�j��
        $this->auth->disableRemberMe();

        // �Z�b�V�����j��
        $this->session->destroy();
    }
    // }}}
}
?>
