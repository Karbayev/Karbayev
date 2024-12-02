<?php
class ControllerExtensionModuleWhatsappWidget extends Controller {
    private $error = [];

    public function install() {
        $this->load->model('setting/extension');
        $this->load->model('setting/module');

        $this->model_setting_extension->install('module', 'whatsapp_widget');

        $this->model_setting_module->addModule('whatsapp_widget', [
            'name' => 'WhatsApp Widget',
            'status' => 1,
            'whatsapp_widget_phone_number' => '', // По умолчанию номер пуст
            'whatsapp_widget_text_list' => '' // Новый параметр для списка
        ]);
    }

    public function uninstall() {
        $this->load->model('setting/extension');
        $this->load->model('setting/module');

        $this->model_setting_extension->uninstall('module', 'whatsapp_widget');
        $this->db->query("DELETE FROM `" . DB_PREFIX . "module` WHERE `code` = 'whatsapp_widget'");
    }

    public function index() {
        $this->load->language('extension/module/whatsapp_widget');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
            $this->model_setting_setting->editSetting('whatsapp_widget', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true));
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['entry_phone_number'] = $this->language->get('entry_phone_number');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_text_list'] = $this->language->get('entry_text_list'); // Новый текст для поля
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['action'] = $this->url->link('extension/module/whatsapp_widget', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true);

        $data['whatsapp_widget_phone_number'] = $this->request->post['whatsapp_widget_phone_number'] ?? $this->config->get('whatsapp_widget_phone_number');
        $data['whatsapp_widget_status'] = $this->request->post['whatsapp_widget_status'] ?? $this->config->get('whatsapp_widget_status');
        $data['whatsapp_widget_text_list'] = $this->request->post['whatsapp_widget_text_list'] ?? $this->config->get('whatsapp_widget_text_list'); // Данные для нового поля

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/whatsapp_widget', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/whatsapp_widget')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
}
