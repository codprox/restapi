<?php 
    /**
     * Mail random class
     * */ 
	class _MyMail{
		public function __construct(){} 
		public function radomGeneratorEmails($names) {
			$email = ''; 
			$extensions = array('.be', '.biz', '.ch', '.com', '.co', '.co.uk', '.de'
				, '.es', '.eu', '.fr', '.gr', '.im', '.info', '.io', '.it', '.lu', '.lt', '.me',
		 		'.mobi', '.mx', '.net', '.nl', '.org', '.pro', '.pt', '.re', '.ru', '.se', 
				'.tel', '.tv', '.aero', '.biz', '.com', '.coop', '.info', '.mobi', '.name', 
				'.net', '.org', '.pro', '.tel', '.travel', '.xxx', '.ag', '.ar.com', '.br.com', 
				'.bz', '.ca', '.cc', '.co', '.gd', '.gs', '.gy', '.hn', '.ht', '.la', '.lc', 
				'.ms', '.mx', '.pe', '.pm', '.qc.com', '.sx', '.tc', '.us', '.us.com', '.us.org'
				, '.uy.com', '.vc', '.vg', '.at', '.be', '.cat', '.ch', '.co.uk', '.com.de', 
				'.de', '.de.com', '.dk', '.es', '.eu', '.eu.com', '.fi', '.fr', '.gb.com', 
				'.gb.net', '.gg', '.gr', '.gr.com', '.hu.com', '.hu.net', '.im', '.it', '.je', 
				'.li', '.lt', '.lu', '.lv', '.me', '.me.uk', '.nl', '.no', '.no.com', '.nu', 
				'.org.uk', '.pl', '.pt', '.ro', '.ru', '.ru.com', '.se', '.se.com', '.se.net', 
				'.uk.com', '.uk.net', '.ru', '.ae.org', '.af', '.am', '.asia', '.cn', '.cn.com',
				'.cx', '.fm', '.hk', '.in', '.in.net', '.io', '.jp', '.jp.net', '.jpn.com', 
				'.ki', '.kr.com', '.mn',    '.nf', '.nz', '.ph', '.pw', '.sa.com', '.sb', '.tl',
				'.tv', '.tw', '.wf', '.ws', '.cm', '.mg', '.mu', '.re', '.sc', '.so', '.tf', 
				'.yt', '.za', '.za.com' );

			$DomainPartA = array('Babble', 'Buzz', 'Blog', 'Blue', 'Brain', 'Bright'
				, 'Browse', 'Bubble', 'Chat', 'Chatter', 'Dab', 'Dazzle', 'Dev', 'Digi', 'Edge',
				 'Feed', 'Five', 'Flash', 'Flip', 'Gab', 'Giga',  'Inno', 'Jabber', 'Jax', 'Jet'
				, 'Jump', 'Link', 'Live', 'My', 'N', 'Photo', 'Pod', 'Real', 'Riff', 'Shuffle', 
				'Snap', 'Skip', 'Tag', 'Tek', 'Thought', 'Top', 'Topic', 'Twitter', 'Word', 
				'You', 'Zoom');
			$DomainPartB = array( 'bean', 'beat', 'bird', 'blab', 'box', 'bridge', 
				'bug', 'buzz', 'cast', 'cat', 'chat', 'club', 'cube', 'dog', 'drive', 'feed', 
				'fire', 'fish', 'fly', 'ify', 'jam', 'links', 'list', 'lounge', 'mix', 'nation',
				 'opia', 'pad', 'path', 'pedia', 'point', 'pulse', 'set', 'space', 'span', 
				'share', 'shots', 'sphere', 'spot', 'storm',  'ster', 'tag', 'tags', 'tube', 
				'tune', 'type', 'verse', 'vine', 'ware', 'wire', 'works', 'XS', 'Z', 'zone', 
				'zoom' );
			$DomainPartC = array('Ai', 'Aba', 'Agi', 'Ava', 'Cami', 'Centi', 'Cogi',
				 'Demi', 'Diva', 'Dyna', 'Ea', 'Ei', 'Fa', 'Ge', 'Ja', 'I', 'Ka', 'Kay', 'Ki', 
				'Kwi', 'La', 'Lee', 'Mee', 'Mi', 'Mu', 'My', 'Oo', 'O', 'Oyo', 'Pixo', 'Pla', 
				'Qua', 'Qui', 'Roo', 'Rhy', 'Ska', 'Sky', 'Ski', 'Ta', 'Tri', 'Twi', 'Tru', 'Vi'
				, 'Voo', 'Wiki', 'Ya', 'Yaki', 'Yo', 'Za', 'Zoo');
			$DomainPartD = array('ba', 'ble', 'boo', 'box', 'cero', 'deo', 'del', 
				'do', 'doo', 'gen', 'jo', 'lane', 'lia', 'lith', 'loo', 'lium', 'mba', 'mbee', 
				'mbo', 'mbu', 'mia', 'mm', 'nder', 'ndo', 'ndu', 'noodle', 'nix', 'nte', 'nti', 
				'nu', 'nyx', 'pe', 're', 'ta', 'tri', 'tz', 'va', 'vee', 'veo', 'vu', 'xo', 'yo'
				, 'zz', 'zzy', 'zio', 'zu');
			
			$rand = mt_rand(0,3); //generer un nombre aléatoire entre 0 et 3
			switch ($rand) {
				case 0:
					$A = $DomainPartA[ mt_rand( 0, count($DomainPartA) - 1) ];
					$B = $DomainPartB[ mt_rand( 0, count($DomainPartB) - 1) ];
					break;
				case 1:
					$A = $DomainPartC[ mt_rand( 0, count($DomainPartC) - 1) ];
					$B = $DomainPartD[ mt_rand( 0, count($DomainPartD) - 1) ];
					break;
				case 2:
					$A = $DomainPartA[ mt_rand( 0, count($DomainPartA) - 1) ];
					$B = $DomainPartD[ mt_rand( 0, count($DomainPartD) - 1) ];
					break;
				case 3:
					$A = $DomainPartC[ mt_rand( 0, count($DomainPartC) - 1) ];
					$B = $DomainPartB[ mt_rand( 0, count($DomainPartB) - 1) ];
					break;
			}
		 
			$email .= $names.'@';
			$email .= $A . $B;
			$email .= $extensions[ mt_rand( 0, count($extensions) - 1) ];
			return strtolower($email);
		}
		public function sendMail($message,$title=null,$to=null){
			$to      = ($to!=null)? $to : 'armandmouele@gmail.com';
			$subject = ($title!=null)? $title : 'Liste des fichiers modifiés';
		}
		public function isMail($email) {
			return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
		}
	}
	 
