<?php
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgContentmeliga extends JPlugin
{
	function plgContentMeliga( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}

	public function onContentPrepare($context, &$row, &$params, $page = 0)
	{
		// Não executa o plugin quando o conteúdo está sendo indexado
		if ($context == 'com_finder.indexer')
		{
			return true;
		}

		if (is_object($row))
		{
			return $this->meliga($row->text, $params);
		}
		return $this->meliga($row, $params);
	}

	protected function meliga(&$text, &$params)
	{
		$phoneDigits1		= $this->params->get('phoneDigits1', 4);
		$phoneDigits2		= $this->params->get('phoneDigits2', 4);

		/* 
		# Encontra 4 números seguidos de um hífen ou espaço opcional, seguido por 4 números. 
        # O número de telefone está no formato XXXX-XXXX ou XXXX XXXX
       */
		$pattern = '/(\W[0-9]{'.$phoneDigits1.'})-? ?(\W[0-9]{'.$phoneDigits2.'})/';

        $replacement = '<a href="tel:$1$2">$1$2</a>';
        $text = preg_replace($pattern, $replacement, $text);

        return true;
	}
}
