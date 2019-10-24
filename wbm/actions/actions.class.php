<?php

/**
 * wbm actions.
 *
 * @package    orangehrm
 * @subpackage Welfare & Benifit (WBM)
 * @author     JBL
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
//require_once '../../lib/common/LocaleUtil.php';
include ('../../lib/common/LocaleUtil.php');

class wbmActions extends sfActions {

    //Benifit Type
    public function executeBenifitType(sfWebRequest $request) {

        try {
            $this->Culture = $this->getUser()->getCulture();
            $this->isAdmin = $_SESSION['isAdmin'];
            $wbmBeniftDao = new wbmDao();

            $this->sorter = new ListSorter('BenifitType', 'wbm', $this->getUser(), array('b.bt_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('wbm/BenifitType');
                }
                $this->var = 1;
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'b.bt_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $wbmBeniftDao->searchBenifitType($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->benifitlist = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSaveBenifitType(sfWebRequest $request) {
        $this->myCulture = $this->getUser()->getCulture();
        $wbmBeniftDao = new wbmDao();
        $wbmBenifit = new BenifitType();
        if ($request->isMethod('post')) {
            if (strlen($request->getParameter('txtName'))) {
                $wbmBenifit->setBt_name(trim($request->getParameter('txtName')));
            } else {
                $wbmBenifit->setBt_name(null);
            }
            if (strlen($request->getParameter('txtNamesi'))) {
                $wbmBenifit->setBt_name_si(trim($request->getParameter('txtNamesi')));
            } else {
                $wbmBenifit->setBt_name_si(null);
            }
            if (strlen($request->getParameter('txtNameta'))) {
                $wbmBenifit->setBt_name_ta(trim($request->getParameter('txtNameta')));
            } else {
                $wbmBenifit->setBt_name_ta(null);
            }

            try {
                $wbmBeniftDao->saveBenifitType($wbmBenifit);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/BenifitType');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/BenifitType');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Added", $args, 'messages')));
            $this->redirect('wbm/BenifitType');
        }
    }

    public function executeUpdateBenifitType(sfWebRequest $request) {
        //Table Lock code is Open


        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $transPid = $request->getParameter('id');
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_wbm_benifit_type', array($transPid), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->resetTableLock('hs_hr_wbm_benifit_type', array($transPid), 1);
                $this->lockMode = 0;
            }
        }

        //Table lock code is closed
        $this->myCulture = $this->getUser()->getCulture();
        $wbmBeniftDao = new wbmDao();
        $wbmBenifit = new BenifitType();

        $benifitTypeCkecklist = $wbmBeniftDao->readBenifitType($request->getParameter('id'));
        if (!$benifitTypeCkecklist) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('wbm/BenifitType');
        }

        $this->benifittypelist = $benifitTypeCkecklist;
        if ($request->isMethod('post')) {
            if (strlen($request->getParameter('txtName'))) {
                $benifitTypeCkecklist->setBt_name(trim($request->getParameter('txtName')));
            } else {
                $benifitTypeCkecklist->setBt_name(null);
            }
            if (strlen($request->getParameter('txtNamesi'))) {
                $benifitTypeCkecklist->setBt_name_si(trim($request->getParameter('txtNamesi')));
            } else {
                $benifitTypeCkecklist->setBt_name_si(null);
            }
            if (strlen($request->getParameter('txtNameta'))) {
                $benifitTypeCkecklist->setBt_name_ta(trim($request->getParameter('txtNameta')));
            } else {
                $benifitTypeCkecklist->setBt_name_ta(null);
            }

            try {
                $wbmBeniftDao->saveBenifitType($benifitTypeCkecklist);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/UpdateBenifitType?id=' . $benifitTypeCkecklist->getBt_id() . '&lock=0');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/UpdateBenifitType?id=' . $benifitTypeCkecklist->getBt_id() . '&lock=0');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
            $this->redirect('wbm/UpdateBenifitType?id=' . $benifitTypeCkecklist->getBt_id() . '&lock=0');
        }
    }

    public function executeDeleteBeniftType(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $wbmBeniftDao = new wbmDao();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_wbm_benifit_type', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $wbmBeniftDao->deleteBenifitType($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_wbm_benifit_type', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/BenifitType');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/BenifitType');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('wbm/BenifitType');
    }

    //Benifit ----------------------------------------------------------------------------------------------------
    public function executeBenifit(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();
            $wbmBeniftDao = new wbmDao();

            $this->sorter = new ListSorter('Benifit', 'wbm', $this->getUser(), array('b.bst_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));


            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('wbm/Benifit');
                }
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'b.bst_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $wbmBeniftDao->searchBenifit($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->benifitlist = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSaveBenifit(sfWebRequest $request) {
        $this->Culture = $this->getUser()->getCulture();
        $wbmBeniftDao = new wbmDao();
        $wbmBenifit = new BenifitSubType();
        $this->loadbtype = $wbmBeniftDao->getBenifitTypeload();

        if ($request->isMethod('post')) {
            $wbmBenifit->setBt_id($request->getParameter('cmbbtype'));
            if (strlen($request->getParameter('txtName'))) {
                $wbmBenifit->setBst_name(trim($request->getParameter('txtName')));
            } else {
                $wbmBenifit->setBst_name(null);
            }
            if (strlen($request->getParameter('txtNamesi'))) {
                $wbmBenifit->setBst_name_si(trim($request->getParameter('txtNamesi')));
            } else {
                $wbmBenifit->setBst_name_si(null);
            }
            if (strlen($request->getParameter('txtNameta'))) {
                $wbmBenifit->setBst_name_ta(trim($request->getParameter('txtNameta')));
            } else {
                $wbmBenifit->setBst_name_ta(null);
            }


            try {
                $wbmBeniftDao->saveBenifit($wbmBenifit);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/Benifit');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/Benifit');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Added", $args, 'messages')));
            $this->redirect('wbm/Benifit');
        }
    }

    public function executeUpdateBenifit(sfWebRequest $request) {
        //Table Lock code is Open

        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $transPid = $request->getParameter('id');
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_wbm_benifit_sub_type', array($transPid), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->resetTableLock('hs_hr_wbm_benifit_sub_type', array($transPid), 1);
                $this->lockMode = 0;
            }
        }

        //Table lock code is closed
        $this->Culture = $this->getUser()->getCulture();
        $wbmBeniftDao = new wbmDao();
        $wbmBenifit = new BenifitSubType();

        $benifitTypeCkecklist = $wbmBeniftDao->readBenifit($request->getParameter('id'));
        if (!$benifitTypeCkecklist) {
            $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
            $this->redirect('wbm/Benifit');
        }
        $this->loadbtype = $wbmBeniftDao->getBenifitTypeload();
        $this->benifittypelist = $benifitTypeCkecklist;
        if ($request->isMethod('post')) {
            $benifitTypeCkecklist->setBt_id($request->getParameter('cmbbtype'));
            if (strlen($request->getParameter('txtName'))) {
                $benifitTypeCkecklist->setBst_name(trim($request->getParameter('txtName')));
            } else {
                $benifitTypeCkecklist->setBst_name(null);
            }
            if (strlen($request->getParameter('txtNamesi'))) {
                $benifitTypeCkecklist->setBst_name_si(trim($request->getParameter('txtNamesi')));
            } else {
                $benifitTypeCkecklist->setBst_name_si(null);
            }
            if (strlen($request->getParameter('txtNameta'))) {
                $benifitTypeCkecklist->setBst_name_ta(trim($request->getParameter('txtNameta')));
            } else {
                $benifitTypeCkecklist->setBst_name_ta(null);
            }
            try {
                $wbmBeniftDao->saveBenifit($benifitTypeCkecklist);
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/UpdateBenifit?id=' . $request->getParameter('id') . '&lock=0');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/UpdateBenifit?id=' . $request->getParameter('id') . '&lock=0');
            }
            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
            $this->redirect('wbm/UpdateBenifit?id=' . $request->getParameter('id') . '&lock=0');
        }
    }

    public function executeDeleteBenift(sfWebRequest $request) {
        if (count($request->getParameter('chkLocID')) > 0) {
            $wbmBeniftDao = new wbmDao();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_wbm_benifit_sub_type', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $wbmBeniftDao->deleteBenifit($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_wbm_benifit_sub_type', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/Benifit');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/Benifit');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('wbm/Benifit');
    }

//Disbusement ------------------------------------------------------------------------------
    public function executeDisbusement(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();
            $wbmBeniftDao = new wbmDao();

            $this->sorter = new ListSorter('Benifit', 'wbm', $this->getUser(), array('b.bst_id', ListSorter::ASCENDING));
            $this->sorter->setSort(array($request->getParameter('sort'), $request->getParameter('order')));

            if ($request->getParameter('mode') == 'search') {
                if (($request->getParameter('searchMode') == 'all') && (trim($request->getParameter('searchValue')) != '')) {
                    $this->setMessage('NOTICE', array('Select the field to search'));
                    $this->redirect('wbm/Disbusement');
                }
            }

            $this->searchMode = ($request->getParameter('searchMode') == null) ? 'all' : $request->getParameter('searchMode');
            $this->searchValue = ($request->getParameter('searchValue') == null) ? '' : $request->getParameter('searchValue');

            $this->sort = ($request->getParameter('sort') == '') ? 'b.bst_id' : $request->getParameter('sort');
            $this->order = ($request->getParameter('order') == '') ? 'ASC' : $request->getParameter('order');
            $res = $wbmBeniftDao->searchDisb($this->searchMode, $this->searchValue, $this->Culture, $this->sort, $this->order, $request->getParameter('page'));
            $this->benifitlist = $res['data'];
            $this->pglay = $res['pglay'];
            $this->pglay->setTemplate('<a href="{%url}">{%page}</a>');
            $this->pglay->setSelectedTemplate('{%page}');
        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('default/error');
        }
    }

    public function executeSaveDisbusement(sfWebRequest $request) {
        try {
            $this->Culture = $this->getUser()->getCulture();
            $wbmBeniftDao = new wbmDao();
            $wbmDisbusement = new Benifit();
            $this->loadbtype = $wbmBeniftDao->getBenifitTypeload();
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('wbm/Disbusement');
        } catch (sfStopException $e) {

        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('wbm/Disbusement');
        }
        if ($request->isMethod('post')) {

            $wbmDisbusement->setEmp_number($request->getParameter('txtEmpId'));
            $wbmDisbusement->setBt_id($request->getParameter('cmbbtype'));
            $wbmDisbusement->setBst_id($request->getParameter('cmbbstype'));
            if($request->getParameter('txtdisbdate')!=null){
            $wbmDisbusement->setBen_date(LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('txtdisbdate')));
            }else{
                $wbmDisbusement->setBen_date(null);
            }
            $wbmDisbusement->setBen_comment(trim($request->getParameter('txtcomment')));
            $this->checkdsr = $wbmBeniftDao->getbd($request->getParameter('txtEmpId'), $request->getParameter('cmbbtype'), $request->getParameter('cmbbstype'), $request->getParameter('txtdisbdate'));
            foreach ($this->checkdsr as $row) {
                if ($row['count'] == 1) {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Record already Exist", $args, 'messages')));
                    $this->redirect('wbm/SaveDisbusement');
                } else {
                    try {
                        $wbmBeniftDao->savedisbust($wbmDisbusement);
                    } catch (Doctrine_Connection_Exception $e) {
                        $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                        $this->setMessage('WARNING', $errMsg->display());
                        $this->redirect('wbm/Disbusement');
                    } catch (Exception $e) {
                        $errMsg = new CommonException($e->getMessage(), $e->getCode());
                        $this->setMessage('WARNING', $errMsg->display());
                        $this->redirect('wbm/Disbusement');
                    }
                    $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Added", $args, 'messages')));
                    $this->redirect('wbm/Disbusement');
                }
            }
        }
    }

    public function executeCheckbtype(sfWebRequest $request) {

        $this->Culture = $this->getUser()->getCulture();
        $wbmBeniftDao = new wbmDao();

        $id = $request->getParameter('id');
        $this->bentype = $wbmBeniftDao->getbent($id);
        $arr = Array();
        if ($this->Culture == "en") {
            $n = "bst_name";
        } else {
            $n = "bst_name_" . $this->Culture;
        }
        foreach ($this->bentype as $row) {
            if ($row[$n] == null) {
                $arr[$row['bst_id']] = $row["bst_name"];
            } else {
                $arr[$row['bst_id']] = $row[$n];
            }
        }

        echo json_encode($arr);
    }

    public function executeUpdateDisbusement(sfWebRequest $request) {
        //Table Lock code is Open


        if (!strlen($request->getParameter('lock'))) {
            $this->lockMode = 0;
        } else {
            $this->lockMode = $request->getParameter('lock');
        }
        $transPid = $request->getParameter('id');
        if (isset($this->lockMode)) {
            if ($this->lockMode == 1) {

                $conHandler = new ConcurrencyHandler();

                $recordLocked = $conHandler->setTableLock('hs_hr_wbm_benifit', array($transPid), 1);

                if ($recordLocked) {
                    // Display page in edit mode
                    $this->lockMode = 1;
                } else {
                    $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record locked by another user.', $args, 'messages')), false);
                    $this->lockMode = 0;
                }
            } else if ($this->lockMode == 0) {
                $conHandler = new ConcurrencyHandler();
                $recordLocked = $conHandler->resetTableLock('hs_hr_wbm_benifit', array($transPid), 1);
                $this->lockMode = 0;
            }
        }

        //Table lock code is closed
        try {
            $this->Culture = $this->getUser()->getCulture();
            $wbmBeniftDao = new wbmDao();
            $benifitTypeCkecklist = $wbmBeniftDao->readDisbrs($request->getParameter('id'));
            if (!$benifitTypeCkecklist) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__('Can not update. Record has been Deleted', $args, 'messages')));
                $this->redirect('wbm/Disbusement');
            }
            $this->loadbtype = $wbmBeniftDao->getBenifitTypeload();

            $this->benifittypelist = $benifitTypeCkecklist;
            $this->loadbstype = $wbmBeniftDao->getBenifitsubbTypeload($this->benifittypelist->getBt_id() . '&lock=0');
        } catch (Doctrine_Connection_Exception $e) {
            $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('wbm/UpdateDisbusement?id=' . $request->getParameter('id') . '&lock=0');
        } catch (sfStopException $e) {

        } catch (Exception $e) {
            $errMsg = new CommonException($e->getMessage(), $e->getCode());
            $this->setMessage('WARNING', $errMsg->display());
            $this->redirect('wbm/UpdateDisbusement?id=' . $request->getParameter('id') . '&lock=0');
        }
        if ($request->isMethod('post')) {
            try {

                $benifitTypeCkecklist->setBen_id($request->getParameter('txtBenID'));
                $benifitTypeCkecklist->setEmp_number($request->getParameter('txtEmpId'));
                $benifitTypeCkecklist->setBt_id($request->getParameter('cmbbtype'));
                $benifitTypeCkecklist->setBst_id($request->getParameter('cmbbstype'));
                $benifitTypeCkecklist->setBen_date("2011-05");
                $benifitTypeCkecklist->setBen_comment(trim($request->getParameter('txtcomment')));

                $this->checkdsr = $wbmBeniftDao->getbd($request->getParameter('txtEmpId'), $request->getParameter('cmbbtype'), $request->getParameter('cmbbstype'), $request->getParameter('txtdisbdate'));
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/UpdateDisbusement?id=' . $request->getParameter('id') . '&lock=0');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/UpdateDisbusement?id=' . $request->getParameter('id') . '&lock=0');
            }
            try {
                if($request->getParameter('txtdisbdate')!=null){
                $date=LocaleUtil::getInstance()->convertToStandardDateFormat($request->getParameter('txtdisbdate'));
                }else{
                    $date=null;
                }
                $wbmBeniftDao->updateDisb($request->getParameter('id'), $request->getParameter('txtEmpId'), $request->getParameter('cmbbtype'), $request->getParameter('cmbbstype'), $date, $request->getParameter('txtcomment'));
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/UpdateDisbusement?id=' . $request->getParameter('id') . '&lock=0');
            } catch (Exception $e) {
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/UpdateDisbusement?id=' . $request->getParameter('id') . '&lock=0');
            }

            $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Updated", $args, 'messages')));
            $this->redirect('wbm/UpdateDisbusement?id=' . $request->getParameter('id') . '&lock=0');
        }
    }

    public function executeDeleteDisbusement(sfWebRequest $request) {

        if (count($request->getParameter('chkLocID')) > 0) {
            $wbmBeniftDao = new wbmDao();
            try {
                $conn = Doctrine_Manager::getInstance()->connection();
                $conn->beginTransaction();
                $ids = array();
                $ids = $request->getParameter('chkLocID');

                $countArr = array();
                $saveArr = array();
                for ($i = 0; $i < count($ids); $i++) {
                    $conHandler = new ConcurrencyHandler();
                    $isRecordLocked = $conHandler->isTableLocked('hs_hr_wbm_benifit', array($ids[$i]), 1);
                    if ($isRecordLocked) {

                        $countArr = $ids[$i];
                    } else {
                        $saveArr = $ids[$i];
                        $wbmBeniftDao->deletedisb($ids[$i]);
                        $conHandler->resetTableLock('hs_hr_wbm_benifit', array($ids[$i]), 1);
                    }
                }

                $conn->commit();
            } catch (Doctrine_Connection_Exception $e) {
                $errMsg = new CommonException($e->getPortableMessage(), $e->getPortableCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/Disbusement');
            } catch (Exception $e) {
                $conn->rollBack();
                $errMsg = new CommonException($e->getMessage(), $e->getCode());
                $this->setMessage('WARNING', $errMsg->display());
                $this->redirect('wbm/Disbusement');
            }
            if (count($saveArr) > 0 && count($countArr) == 0) {
                $this->setMessage('SUCCESS', array($this->getContext()->getI18N()->__("Successfully Deleted", $args, 'messages')));
            } elseif (count($saveArr) > 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Some records are can not be deleted as them  Locked by another user ", $args, 'messages')));
            } elseif (count($saveArr) == 0 && count($countArr) > 0) {
                $this->setMessage('WARNING', array($this->getContext()->getI18N()->__("Can not delete as them  Locked by another user ", $args, 'messages')));
            }
        } else {
            $this->setMessage('NOTICE', array('Select at least one record to delete'));
        }
        $this->redirect('wbm/Disbusement');
    }

    public function setMessage($messageType, $message = array(), $persist=true) {
        $this->getUser()->setFlash('messageType', $messageType, $persist);
        $this->getUser()->setFlash('message', $message, $persist);
    }

    public function executeError(sfWebRequest $request) {

        $this->redirect('default/error');
    }

}

?>
