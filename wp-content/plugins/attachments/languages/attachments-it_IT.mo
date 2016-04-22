��    3      �  G   L      h  �   i  k   �  m  `     �  �   �     ~     �  �   �     l	     �	     �	  �   �	  \   �
  o   �
  N   n  �   �     \     d     k     �     �  �  �  j   }  �   �  %   �  v   �     0     @     W     w     �  1   �     �     �     �  (        /  $   6     [     q  u   �  s   �  C   p  P   �          "     (  $   6  7   [  W   �  ,  �  �     �   �  �  @       �        �     �  �   �     �     �     �  �      m   �  v   g  g   �  �   F  
             !     4     <    R  `   V!  �   �!     X"  z   x"     �"     #  2   ##     V#     l#  0   t#     �#     �#  %   �#  6   �#     .$  &   6$     ]$     w$  n   �$  j   �$  J   f%  H   �%  "   �%     &     $&  /   2&  7   b&  P   �&     "   %            	          -             0             (          .       #                    /   *               1                              2   &   
          3                       +      )                            '   ,      !          $    <strong>Attachments has changed significantly since it's last update.</strong> These changes <em>will affect your themes and plugins</em>. <strong>Attachments has detected legacy Attachments data.</strong> A lot has changed since Attachments 1.x. A lot has changed since Attachments 1.x. The entire codebase was rewritten to not only make better use of the stellar Media updates in WordPress 3.5, but to also facilitate some exciting features coming down the line. With this rewrite came significant changes to the way you will work with Attachments. One of the biggest changes in Attachments 3.0 is the ability to create multiple meta boxes of Attachments, each with any number of custom fields you define. By default, Attachments will re-implement the meta box you've been using until now, but <strong>you will need to trigger a migration to the new format</strong>. Additinoal instructions As always has been the case with Attachments, editing your theme files is required. The syntax to do so has changed in Attachments 3.0. Please read the Attach Attachments Attachments 3.0 ships with what are called <em>instances</em>. An instance is equivalent to a meta box on an edit screen and it has a number of properties you can customize. Please read the README for more information. Attachments 3.x Caption Attachments 3.x Instance Attachments 3.x Title Attachments does not directly integrate with your theme out of the box, you will need to edit your theme's template files where appropriate. You can add the following within The Loop to retrieve all Attachments data for the current post: Attachments has found records from version 1.x. Would you like to migrate them to version 3? Attachments requires PHP 5.2 or higher, as does WordPress 3.2+. Attachments has been automatically deactivated. Attachments requires PHP 5.2+. Attachments has been automatically deactivated. By default, Attachments implements a single meta box on Posts and Pages with two fields. You can disable this default instance by adding the following to your Caption Change Currently limited to Delete Find out more If you have existing Attachments 1.x data and are using it, a migration script has been bundled here and you can use it below. If you would like to directly migrate from Attachments 1.x to Attachments 3.x you can use the defaults put in place and your data will be migrated to the new format quickly and easily. Alternatively, if you'd like to customize the fields you're using a bit, you can do that first and then adjust the migration parameters to map the old fields to your new ones. If you would like to forcefully revert to the 1.x version branch of Attachments, add the following to your If you would like to immediately <em>revert to the old version of Attachments</em> you may do so by downgrading the plugin install itself, or adding the following to your Immediate Reversal to Attachments 1.x In order to migrate Attachments 1.x data, you need to set which instance and fields in version 3.0+ you'd like to use: Invalid request Meta box customization Migrate legacy Attachments data Migrate legacy data Migrated Migrating Attachments 1.x data to Attachments 3.x Migration Complete! Migration Step 1 Migration has already Run! Overview of changes from Attachments 1.x Remove Retrieving Attachments in your theme Revert to version 1.x Setting up Instances The <code>Caption</code> field data will be migrated to this field name in Attachments 3.x. Leave empty to disregard. The <code>Title</code> field data will be migrated to this field name in Attachments 3.x. Leave empty to disregard. The instance name you would like to use in the migration. Required. The migration has already been run. The migration process has not been repeated. The migration has completed. Title Toggle Fields Using Attachments data in your theme You have already migrated your legacy Attachments data. Your Attachments meta box(es) can be customized by adding the following to your theme's Project-Id-Version: Attachments v3.4
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2013-05-09 18:09+0100
PO-Revision-Date: 2013-11-15 23:58+0100
Last-Translator: Marco <marco@blackstudio.it>
Language-Team: Black Studio <info@blackstudio.it>
Language: it_IT
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Poedit-KeywordsList: _;gettext;gettext_noop;__;_e;_ngettext:1,2
X-Poedit-Basepath: ../
X-Poedit-SourceCharset: UTF-8
Plural-Forms: nplurals=2; plural=(n != 1);
X-Generator: Poedit 1.5.7
X-Poedit-SearchPath-0: .
 <strong>Attachments è cambiato significativamente dall'ultimo aggiornamento.</strong> Queste modifiche <em>avranno effetto sui tuoi temi e plugin</em>. <strong>Attachments ha rilevato la presenza di dati di una versione precedente.</strong> Molte cose sono cambiate rispetto ad Attachments 1.x. Molte cose sono cambiate rispetto ad Attachments 1.x. Tutto il codice è stato riscritto non solo per fare un uso migliore degli aggiornamenti della Libreria Media di Wordpress 3.5, ma anche per facilitare l'aggiunta di nuove funzionalità. Come conseguenza di questo ci sono significativi cambiamenti al modo con cui operare con Attachments. Una delle modifiche principali in Attachments 3.0 è la possibilità di creare istanze multiple di allegati, ognuna con un numero indefinito di campi personalizzati che si possono definire. Come impostazione predefinita, Attachments reimplementerà l'istanza che hai utilizzato fino ad ora, ma <strong>dovrai effettuare una migrazione al nuovo formato</strong>. Istruzioni addizionali Così com'è sempre stato con Attachments, è necessario modificare i file del tuo tema. La sintassi per fare ciò è cambiata in Attachments 3.0. Leggi il Allega Attachments Attachments 3.0 supporta le cosiddette <em>istanze</em>. Una istanza è l'equivalente di un riquadro (meta box) nella schermata di modifica ed ha delle caratteristiche personalizzabili. Leggere il file README per maggiori informazioni. Didascalia Attachments 3.x Istanza di Attachments 3.x Titolo Attachments 3.x Attachments non si integra direttamente con il tuo tema, ma dovrai modificare i file dei template del tuo tema in modo appropriato. Puoi aggiungere il seguente codice all'interno del "Loop" per recuperare i dati degli allegati per il post corrente. Attachments ha rilevato dei dati della versione 1.x. Vuoi effettuare la migrazione di questi alla versione 3? Attachments richiede PHP 5.2 o superiore, così come WordPress 3.2+. Attachments è stato automaticamente disattivato. Attachments richiede PHP 5.2 o una versione successiva. Il plugin è stato automaticamente disattivato. Come impostazione predefinita, Attachments implementa un singolo meta box negli Articoli e nella Pagine con due campi. Puoi disabilitare questa istanza di default aggiungendo il seguente codice al tuo Didascalia Cambia Limite impostato a Elimina Maggiori informazioni Se hai dei dati esistenti di Attachments 1.x e li stai utilizzando, è disponibile uno script di migrazione che puoi utilizzare qui sotto. Se vuoi migrare direttamente da Attachments 1.x ad Attachments 3.x puoi utilizzare le impostazioni predefinite ed i tuoi dati saranno migrati al nuovo formato in modo semplice e rapido. In alternativa, se vuoi personalizzare i campi in uso, lo puoi fare preventivamente ed in seguito impostare i parametri di migrazione per la corrispondenza tra i vecchi campi e quelli nuovi. Se vuoi forzare l'utilizzo della versione 1.x di Attachments, aggiungi il seguente codice al tuo Se vuoi <em>ripristinare la vecchia versione di Attachments</em> lo puoi fare reinstallando la versione precedente, oppure aggiungendo il seguente codice al tuo Torna subito ad Attachments 1.x Per migrare i dati di Attachments 1.x, devi impostare quale istanza e quali campi della versione 3.0+ vorresti utilizzare: Richiesta non valida Personalizzazione meta box Migrazione dati versione precedente di Attachments Migra dati precedenti Migrato Migrazione da Attachments 1.x ad Attachments 3.x Migrazione completata! Migrazione - Passo 1 La migrazione è già stata eseguita! Panoramica delle modifiche rispetto ad Attachments 1.x Rimuovi Visualizzare gli allegati nel tuo tema Ritorna alla versione 1.x Impostazione istanze Il campo <code>Didascalia</code> sarà migrato a questo campo in Attachments 3.x. Lasciare vuoto per ignorare. Il campo <code>Titolo</code> sarà migrato a questo campo in Attachments 3.x. Lasciare vuoto per ignorare. Il nome dell'istanza che vorresti utilizzare nella migrazione. Necessario. La migrazione è già stata eseguita. Il processo non è stato ripetuto. La migrazione è stata completata. Titolo Alterna campi Visualizzare i dati degli allegati nel tuo tema Hai già migrato i tuoi dati precedenti di Attachments. Il tuo meta box può essere personalizzato aggiungendo il seguente codice al tuo 