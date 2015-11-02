<?php

/**
 * 业务层基类
 */
class Alumni_Base_Service {
    
    /**
     * 错误码 需要登录
     */
    const ERR_NEED_LOGIN = 'TE00002';
    
    /**
     * 错误码 操作失败
     */
    const ERR_OPER_FAIL = 'TE00003';
    
    /**
     * 错误码 操作成功
     */
    const ERR_OPER_SUCC = 'TE00001';
    
    /**
     * 错误码 未知错误
     */
    const ERR_OPER_OTHER = 'TE00000';
    
    /**
     * 错误码 不存在
     */
    const ERR_NOT_FOUND = 'TE00004';
    
    /**
     * 错误码 无效输入
     */
    const ERR_INPUT_INVALID = 'TE00005';
    
    /**
     *
     * @var string 错误代码
     */
    protected $errorCode;
    
    /**
     *
     * @var string 错误描述
     */
    protected $errorMessage;
    
    /**
     * 业务方法内部出现错误时,设置错误消息
     * @param string $code
     * @param string $message
     */
    protected function setError($code, $message) {
        $this->errorCode = $code;
        $this->errorMessage = $message;
    }
    
    /**
     * 
     * @return string 错误代码
     */
    public function getErrorCode() {
        return $this->errorCode;
    }
    
    /**
     * 
     * @return string 错误消息
     */
    public function getErrorMessaage() {
        return $this->errorMessage;
    }
}