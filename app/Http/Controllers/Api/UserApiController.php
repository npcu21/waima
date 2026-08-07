<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Str;  
// ✅ Models
use App\Models\User;
use App\Models\Agent;
use App\Models\Supplier;
use App\Models\Language;
use App\Models\Notification;




class UserApiController extends Controller
{

public function getAppTranslations(Request $request)
{
    // Get language_id from query (default = 1)
    $language_id = (int) $request->query('language_id', 1);

    // All translations grouped properly
    $translations = [

        // ===============================
        // ENGLISH TRANSLATIONS
        // ===============================
        'en' => [

            // Registration Form Labels
            'registration_form' => [
                'username'     => 'Username',
                'name'         => 'Full Name',
                'email'        => 'Email Address',
                'phone'        => 'Phone Number',
                'password'     => 'Password',
                'usertype_id'  => 'User Type',
                'country_id'   => 'Country',
                'language_id'  => 'Language',
                'image'        => 'Profile Image',
            ],

            // Validation messages
            'validation' => [
                'username_required' => 'Username is required',
                'name_required' => 'Full name is required',
                'email_required' => 'Email is required',
                'email_email' => 'Email must be a valid email address',
                'phone_required' => 'Phone number is required',
                'phone_digits' => 'Phone number must be 10 digits',
                'password_required' => 'Password is required',
                'password_min' => 'Password must be at least 6 characters',
                'image_mimes' => 'Profile image must be a valid image (jpeg, png, jpg)',
            ],

            // Common Texts
            'common' => [
                'welcome' => 'Welcome',
                'login_success' => 'Login Successful',
                'total_products' => 'Total Products',
                'total_inquiries' => 'Total Inquiries',
                'home' => 'Home',
                'products' => 'Products',
                'categories' => 'Categories',
                'account' => 'Account',
            ],

            // Product Texts
            'product_texts' => [
                'product_list' => 'Product List',
                'export' => 'Export',
                'new_product' => 'New Product',
                'what_products_do_you_sell' => 'What products do you sell?',
                'type_of_products' => 'Type of Products',
            ],

            // Farmer Inquiry (NEW)
            'farmer_inquiry' => [
                'name' => 'Name',
                'email' => 'Email',
                'mobile_no' => 'Mobile Number',
                'enquiry_type' => 'Enquiry Type',
                'description' => 'Description',
                'created_by' => 'Created By',
                'supplier_id' => 'Supplier ID',
                'language_id' => 'Language ID',
            ],

            // 🔥 ALL OTHER ENGLISH TEXTS
            'app_texts' => [
                'untranslated_contents' => 'Untranslated contents',
                'offline_mode' => 'Offline mode',
                'select_user_type' => 'Select user type',
                'success' => 'Success',
                'check_your_email' => 'Check your email',
                'reset_link_sent' => 'We sent a reset link to {email_address}. Enter the 6-digit code mentioned in the email.',
                'error' => 'Error',
                'incorrect_otp' => 'Incorrect OTP',
                'verify_code' => 'Verify Code',
                'email_not_received' => 'Haven’t received the email yet?',
                'resend_email' => 'Resend email',
                'login' => 'Log in',
                'signup' => 'Sign up',
                'forgot_password' => 'Forgot password',
                'reset_password' => 'Reset Password',
                'login_as' => 'Login as',
                'user_type_missing' => 'User type is missing',
                'select_user_type_first' => 'Please select user type first!',
                'continue' => 'Continue',
                'dont_have_account' => 'Don’t have an account?',
                'password_mismatch' => 'Password doesn’t match!',
                'signup_as' => 'Sign up as',
                'country_missing' => 'Country is missing',
                'select_country_first' => 'Please select country first!',
                'already_have_account' => 'Already have an account?',
                'login_here' => 'Login here',
                'Change_image' => 'Change Image',
                'upload_image' => 'Upload an image',
                'type_message' => 'Type your message...',
                'clear' => 'Clear',
                'settings' => 'Settings',
                'chat_list' => 'Chat List',
                'no_chats_found' => 'No chats found',
                'inquiries' => 'Inquiries',
                'latest_update' => 'Latest update:',
                'supplier' => 'Supplier',
                'agent' => 'Agent',
                'farmer' => 'Farmer',
                'view_profile' => 'View profile',
                'informative_documents_uploaded' => 'Informative Documents Uploaded by Admin',
                'view_document' => 'View Document',
                'view_documents' => 'View Documents',
                'total_supplier' => 'Total Supplier',
                'view_all_products' => 'View All Products',
                'add_new_product' => 'Add New Product',
                'view_all_supplier' => 'View All Supplier',
                'add_new_supplier' => 'Add New Supplier',
                'watchlist' => 'Watchlist',
                'recent_products' => 'Recent Products',
                'view_all' => 'View all',
                'change_language' => 'Change language',
                'choose_language' => 'Choose the language',
                'select_preferred_language' => 'Select your preferred language below. This helps serve you better.',
                'languages' => 'Languages',
                'no_languages_available' => 'No languages available',
                'product_type_required' => 'Product type is required',
                'supplier_required' => 'Supplier is required',
                'next' => 'Next',
                'product_detail' => 'Product Detail',
                'update' => 'Update',
                'variety_name' => 'Variety Name',
                'send_enquiry' => 'Send Enquiry',
                'message' => 'Message',
                'send' => 'Send',
                'product' => 'Product',
                'no_data_available' => 'No data available',
                'action' => 'Action',
                'add_more_product' => 'Add More Product',
                'select_product' => 'Select Product',
                'cancel' => 'Cancel',
                'enter_category_info' => 'Please enter {category_name} info',
                'select_date' => 'Select Date',
                'close' => 'Close',
                'user_data_not_found' => 'User data not found.',
                'fill_required_fields' => 'Please fill all required fields',
                'enter_identification_info' => 'Please enter your identification info',
                'supplier_info' => 'Supplier Info',
                'enter_supplier_info' => 'Please enter your Supplier info',
                'select_supplier' => 'Select Supplier',
                'logout' => 'Logout',
                'edit_profile' => 'Edit Profile',
                'first_name_required' => 'First name is required',
                'first_name' => 'First name',
                'last_name_required' => 'Last name is required',
                'last_name' => 'Last name',
                'filter' => 'Filter',
                'not_found' => 'Not Found',
                'agri_system' => 'Regional Agricultural Information System',
                'skip' => 'Skip',
                'contact_no' => 'Contact No:',
                'address' => 'Address:',
                'create_supplier_profile' => 'Please Create Supplier Profile',
                'company_name' => 'Company Name',
                'company_name_required' => 'Company name is required',
                'manager_name' => 'Manager Name',
                'manager_name_required' => 'Manager name is required',
                'position' => 'Position',
                'position_required' => 'Position is required',
                'example_owner' => 'ex: Owner',
                'state_entity_registration' => 'State Entity Registration #',
                'state_entity_registration_required' => 'State Entity Registration is required',
                'employer_id' => 'Employer Identification Number',
                'employer_id_required' => 'Employer Id No. is required',
                'location' => 'Location',
                'enter_location_info' => 'Please enter Location info',
                'where_is_supplier' => 'Where is supplier located?',
                'use_my_location' => 'Use My Current Location',
                'find_by_address' => 'Find by Address',
                'area_name' => 'Area Name*',
                'city' => 'City',
                'city_required' => 'City is required',
                'enter_city' => 'Enter City*',
                'region' => 'Region',
                'region_required' => 'Region is required',
                'enter_region' => 'Enter Region*',
                'enter_address' => 'Enter Address*',
                'address_required' => 'Address is required',
                'business_info' => 'Please enter your Business info',
                'upload_photos' => 'Please upload Photos',
                'supplier_profile' => 'Supplier Profile',
                'mobile_no' => 'Mobile No',
                'company_detail' => 'Company Detail',
                'wholesale' => 'Wholesale',
                'retail' => 'Retail',



                'confirm_password' => 'Confirm Password',
                'confirm_password_required' => 'Confirm password is required',
                'terms_and_condition' => 'Terms & Condition',
                'privacy_policy' => 'Privacy Policy',
                'account_details' => 'Account Details',
                'follow_link_to_view_document' => 'Follow link to view document',
                'submit' => 'Submit',
                'label_name_required' => '{label_name} is required',
                'message_required' => 'Message is required',
                'reply_only_to_message' => 'You can only reply to a message',
                'logout_confirmation' => 'Are you sure you want to logout from device?',
                'yes' => 'Yes',
                'no' => 'No',
                'location_services_disabled' => 'Location services are disabled.',
                'use_gallery' => 'Use Gallery',
                'use_camera' => 'Use Camera',
                'image_required' => 'Image is required',
                'suppliers' => 'Suppliers',
                'search' => 'Search',
                'select_country' => 'Select country',

                 'status_pending' => 'Pending',
    'status_active' => 'Active',
    'status_suspended' => 'Suspended',
    'status_rejected' => 'Rejected',
    'unverified_account' => 'Unverified Account',
    'update_supplier' => 'Update Supplier',
    'notifications' => 'Notifications',
    'clear_all' => 'Clear All',
    'announcements' => 'Announcements',
    'filter_price_movements' => 'Filter Price Movements',
    'filter_products' => 'Filter Products',
    'category' => 'Category',
    'choose_category' => 'Choose Category',
    'time_period' => 'Time Period',
    'choose_time_period' => 'Choose Time Period',
    'apply_filter' => 'Apply Filter',
    'yield' => 'Yield',
    'price' => 'Price',
    'from_price' => 'from (price)',
    'to_price' => 'to (price)',
    'send_enquiries' => 'Send Enquiries',
    'enquiry_type' => 'Enquiry Type',
    'select_enquiry_type' => 'Select enquiry type',
    'syncing' => 'Syncing…',
    'data_synced_successfully' => 'Data synced successfully',
    'saved_offline' => 'Saved offline. Will sync automatically when you are back online.',
    'in_review' => 'In Review',
    'update_product_status' => 'Update Product Status',
     'technical_specifications'      => 'Technical and Specifications',
    'unverified_account_key'        => 'Your account is unverified',
    'account_not_verified_yet'      => 'Your account is not verified yet.',
    'change'                        => 'Change',
    'status'                        => 'Status',
     'guest_login'                => 'Guest Login',
    'sign_in_to_continue'        => 'Sign In To Continue',
    'incomplete_data'            => 'Incomplete data',
    'favorites'                  => 'Favorites',
    'pre_order_product'          => 'Pre Order Product',
    'product_delivery_location'  => 'Product Delivery Location',
    'location_required'          => 'Location is required',
    'product_quantity'           => 'Product Quantity',
    'description_required'       => 'Description is required',
    'order_types'                => 'Order Types',
    'select_order_type'          => 'Select Order Type',
    'select_order_type_first'    => 'Select order type first',
    'delivery'                   => 'Delivery',
    'pick_up'                    => 'Pick-up',
    'pre_ordered_products'       => 'Pre Ordered Products',
    'quantity'                   => 'Quantity',
    'order_type'                 => 'Order Type',
    'requested_at'               => 'Requested at',
    'view_supplier_response'     => 'View Supplier Response',
    'supplier_response'          => 'Supplier Response',
    'responded_at'               => 'Responded at:',
    'order_status'               => 'Order Status -',
    'available_quantity'         => 'Available Quantity -',
    'price'                      => 'Price',
    'update_order'               => 'Update Order',
    'product_price'              => 'Product Price',
    'price_required'             => 'Price is required',
    'available_product_quantity' => 'Available Product Quantity',
    'remarks'                    => 'Remarks',
    'remark_required'            => 'Remark is required',
    'select_status_first'        => 'Select status first',
    'add_more_suppliers'         => 'Add more suppliers',
    'load_more'                  => 'Load More',
    'continue_guest'                  => 'Continue as Guest',
        'price_comparison_chart' => 'Price Comparison Chart',
        'show_all'               => 'Show All',
        'view_pre_orders'        => 'View Pre-Orders',
        'choose_product'         => 'Choose Product',
        'category_price_trend'   => '{category_name} Price Trend',
        'view_price_trends'      => 'View Price Trends',
    

            ],
        ],

        // ===============================
        // FRENCH TRANSLATIONS
        // ===============================
        'fr' => [

            'registration_form' => [
                'username'     => 'Nom d’utilisateur',
                'name'         => 'Nom complet',
                'email'        => 'Adresse e-mail',
                'phone'        => 'Numéro de téléphone',
                'password'     => 'Mot de passe',
                'usertype_id'  => 'Type d’utilisateur',
                'country_id'   => 'Pays',
                'language_id'  => 'Langue',
                'image'        => 'Image de profil',
            ],

            'validation' => [
                'username_required' => 'Le nom d’utilisateur est requis',
                'name_required' => 'Le nom complet est requis',
                'email_required' => 'L’adresse e-mail est requise',
                'email_email' => 'L’adresse e-mail doit être valide',
                'phone_required' => 'Le numéro de téléphone est requis',
                'phone_digits' => 'Le numéro de téléphone doit comporter 10 chiffres',
                'password_required' => 'Le mot de passe est requis',
                'password_min' => 'Le mot de passe doit comporter au moins 6 caractères',
                'image_mimes' => 'L’image de profil doit être une image valide (jpeg, png, jpg)',
            ],

            'common' => [
                'welcome' => 'Bienvenue',
                'login_success' => 'Connexion réussie',
                'total_products' => 'Nombre total de produits',
                'total_inquiries' => 'Nombre total de demandes',
                'home' => 'Accueil',
                'products' => 'Produits',
                'categories' => 'Catégories',
                'account' => 'Compte',
            ],

            'product_texts' => [
                'product_list' => 'Liste des produits',
                'export' => 'Exporter',
                'new_product' => 'Nouveau produit',
                'what_products_do_you_sell' => 'Quels produits vendez-vous ?',
                'type_of_products' => 'Type de produits',
            ],

            // Farmer Inquiry (NEW)
            'farmer_inquiry' => [
                'name' => 'Nom',
                'email' => 'E-mail',
                'mobile_no' => 'Numéro de mobile',
                'enquiry_type' => 'Type de demande',
                'description' => 'Description',
                'created_by' => 'Créé par',
                'supplier_id' => 'ID du fournisseur',
                'language_id' => 'ID de la langue',
            ],

            // 🔥 FULL FRENCH TRANSLATION
            'app_texts' => [
                'untranslated_contents' => 'Contenus non traduits',
                'offline_mode' => 'Mode hors ligne',
                'select_user_type' => 'Sélectionnez le type d’utilisateur',
                'success' => 'Succès',
                'check_your_email' => 'Vérifiez votre e-mail',
                'reset_link_sent' => 'Nous avons envoyé un lien de réinitialisation à {email_address}. Saisissez le code à 6 chiffres indiqué dans l’e-mail.',
                'error' => 'Erreur',
                'incorrect_otp' => 'Code OTP incorrect',
                'verify_code' => 'Vérifier le code',
                'email_not_received' => 'Vous n’avez pas encore reçu l’e-mail ?',
                'resend_email' => 'Renvoyer l’e-mail',
                'login' => 'Connexion',
                'signup' => 'Inscription',
                'forgot_password' => 'Mot de passe oublié',
                'reset_password' => 'Réinitialiser le mot de passe',
                'login_as' => 'Se connecter en tant que',
                'user_type_missing' => 'Le type d’utilisateur est manquant',
                'select_user_type_first' => 'Veuillez d’abord sélectionner un type d’utilisateur !',
                'continue' => 'Continuer',
                'dont_have_account' => 'Vous n’avez pas de compte ?',
                'password_mismatch' => 'Le mot de passe ne correspond pas !',
                'signup_as' => 'Inscrivez-vous en tant que',
                'country_missing' => 'Le pays est manquant',
                'select_country_first' => 'Veuillez d’abord sélectionner un pays !',
                'already_have_account' => 'Vous avez déjà un compte ?',
                'login_here' => 'Connectez-vous ici',
                'change_image' => 'Changer l’image',
                'upload_image' => 'Télécharger une image',
                'type_message' => 'Tapez votre message…',
                'clear' => 'Effacer',
                'settings' => 'Paramètres',
                'chat_list' => 'Liste des discussions',
                'no_chats_found' => 'Aucune discussion trouvée',
                'inquiries' => 'Demandes',
                'latest_update' => 'Dernière mise à jour :',
                'supplier' => 'Fournisseur',
                'agent' => 'Agent',
                'farmer' => 'Agriculteur',
                'view_profile' => 'Voir le profil',
                'informative_documents_uploaded' => 'Documents informatifs téléversés par l’administrateur',
                'view_document' => 'Voir le document',
                'view_documents' => 'Voir les documents',
                'total_supplier' => 'Nombre total de fournisseurs',
                'view_all_products' => 'Voir tous les produits',
                'add_new_product' => 'Ajouter un nouveau produit',
                'view_all_supplier' => 'Voir tous les fournisseurs',
                'add_new_supplier' => 'Ajouter un nouveau fournisseur',
                'watchlist' => 'Liste de suivi',
                'recent_products' => 'Produits récents',
                'view_all' => 'Tout voir',
                'change_language' => 'Changer de langue',
                'choose_language' => 'Choisissez la langue',
                'select_preferred_language' => 'Sélectionnez votre langue préférée ci-dessous. Cela nous aide à mieux vous servir.',
                'languages' => 'Langues',
                'no_languages_available' => 'Aucune langue disponible',
                'product_type_required' => 'Le type de produit est requis',
                'supplier_required' => 'Le fournisseur est requis',
                'next' => 'Suivant',
                'product_detail' => 'Détail du produit',
                'update' => 'Mettre à jour',
                'variety_name' => 'Nom de la variété',
                'send_enquiry' => 'Envoyer une demande',
                'message' => 'Message',
                'send' => 'Envoyer',
                'product' => 'Produit',
                'no_data_available' => 'Aucune donnée disponible',
                'action' => 'Action',
                'add_more_product' => 'Ajouter plus de produits',
                'select_product' => 'Sélectionnez un produit',
                'cancel' => 'Annuler',
                'enter_category_info' => 'Veuillez saisir les informations de {category_name}',
                'select_date' => 'Sélectionnez la date',
                'close' => 'Fermer',
                'user_data_not_found' => 'Données utilisateur introuvables.',
                'fill_required_fields' => 'Veuillez remplir tous les champs obligatoires',
                'enter_identification_info' => 'Veuillez saisir vos informations d’identification',
                'supplier_info' => 'Informations du fournisseur',
                'enter_supplier_info' => 'Veuillez saisir les informations du fournisseur',
                'select_supplier' => 'Sélectionnez un fournisseur',
                'logout' => 'Déconnexion',
                'edit_profile' => 'Modifier le profil',
                'first_name_required' => 'Le prénom est requis',
                'first_name' => 'Prénom',
                'last_name_required' => 'Le nom de famille est requis',
                'last_name' => 'Nom de famille',
                'filter' => 'Filtrer',
                'not_found' => 'Introuvable',
                'agri_system' => 'Système régional d\'information agricole',
                'skip' => 'Passer',
                'contact_no' => 'N° de contact :',
                'address' => 'Adresse :',
                'create_supplier_profile' => 'Veuillez créer un profil de fournisseur',
                'company_name' => 'Nom de l’entreprise',
                'company_name_required' => 'Le nom de l’entreprise est requis',
                'manager_name' => 'Nom du responsable',
                'manager_name_required' => 'Le nom du responsable est requis',
                'position' => 'Poste',
                'position_required' => 'Le poste est requis',
                'example_owner' => 'ex. : Propriétaire',
                'state_entity_registration' => 'N° d’enregistrement de l’entité',
                'state_entity_registration_required' => 'L’enregistrement de l’entité est requis',
                'employer_id' => 'Numéro d’identification de l’employeur',
                'employer_id_required' => 'Le numéro d’identification de l’employeur est requis',
                'location' => 'Localisation',
                'enter_location_info' => 'Veuillez saisir les informations de localisation',
                'where_is_supplier' => 'Où se trouve le fournisseur ?',
                'use_my_location' => 'Utiliser ma position actuelle',
                'find_by_address' => 'Rechercher par adresse',
                'area_name' => 'Nom de la zone*',
                'city' => 'Ville',
                'city_required' => 'La ville est requise',
                'enter_city' => 'Entrez la ville*',
                'region' => 'Région',
                'region_required' => 'La région est requise',
                'enter_region' => 'Entrez la région*',
                'enter_address' => 'Entrez l’adresse*',
                'address_required' => 'L’adresse est requise',
                'business_info' => 'Veuillez saisir les informations de votre entreprise',
                'upload_photos' => 'Veuillez téléverser des photos',
                'supplier_profile' => 'Profil du fournisseur',
                'mobile_no' => 'Numéro de mobile',
                'company_detail' => 'Détails de l’entreprise',
                'wholesale' => 'Gros',
                'retail' => 'Détail',


                'confirm_password' => 'Confirmer le mot de passe',
                'confirm_password_required' => 'La confirmation du mot de passe est requise',
                'terms_and_condition' => 'Termes et conditions',
                'privacy_policy' => 'Politique de confidentialité',
                'account_details' => 'Détails du compte',
                'follow_link_to_view_document' => 'Suivez le lien pour voir le document',
                'submit' => 'Soumettre',
                'label_name_required' => '{label_name} est requis',
                'message_required' => 'Le message est requis',
                'reply_only_to_message' => 'Vous ne pouvez répondre qu’à un message',
                'logout_confirmation' => 'Êtes-vous sûr de vouloir vous déconnecter de l’appareil ?',
                'yes' => 'Oui',
                'no' => 'Non',
                'location_services_disabled' => 'Les services de localisation sont désactivés.',
                'use_gallery' => 'Utiliser la galerie',
                'use_camera' => 'Utiliser la caméra',
                'image_required' => 'L’image est requise.',
                'suppliers' => 'Fournisseurs',
                'search' => 'Rechercher',
                'select_country' => 'Sélectionner un pays',



                'status_pending' => 'En attente',
    'status_active' => 'Actif',
    'status_suspended' => 'Suspendu',
    'status_rejected' => 'Rejeté',
    'unverified_account' => 'Unverified Account',
    'update_supplier' => 'Update Supplier',
    
    'notifications' => 'Notifications',
    'clear_all' => 'Tout Effacer',
    'announcements' => 'Annonces',
    'filter_price_movements' => 'Filtrer les Mouvements de Prix',
    'filter_products' => 'Filtrer les Produits',
    'category' => 'Catégorie',
    'choose_category' => 'Choisir une Catégorie',
    'time_period' => 'Période',
    'choose_time_period' => 'Choisir la Période',
    'apply_filter' => 'Appliquer le Filtre',
    'yield' => 'Rendement',
    'price' => 'Prix',
    'from_price' => 'de (prix)',
    'to_price' => 'à (prix)',
    'send_enquiries' => 'Envoyer des Demandes',
    'enquiry_type' => 'Type de Demande',
    'select_enquiry_type' => 'Sélectionner le Type de Demande',
    'syncing' => 'Synchronisation…',
    'data_synced_successfully' => 'Données synchronisées avec succès',
    'saved_offline' => 'Enregistré hors ligne. Se synchronisera automatiquement lorsque vous serez de nouveau en ligne.',
    'in_review' => 'En Revue',
    'update_product_status' => 'Mettre à Jour le Statut du Produit',
     'technical_specifications'      => 'Techniques et Spécifications',
    'unverified_account_key'        => 'Votre compte n’est pas vérifié',
    'account_not_verified_yet'      => 'Votre compte n’est pas encore vérifié.',
    'change'                        => 'Modifier',
    'status'                        => 'Statut',

'guest_login'                => 'Connexion Invité',
    'sign_in_to_continue'        => 'Connectez-vous pour continuer',
    'incomplete_data'            => 'Données incomplètes',
    'favorites'                  => 'Favoris',
    'pre_order_product'          => 'Produit en précommande',
    'product_delivery_location'  => 'Lieu de livraison du produit',
    'location_required'          => 'Le lieu est requis',
    'product_quantity'           => 'Quantité du produit',
    'description_required'       => 'La description est requise',
    'order_types'                => 'Types de commande',
    'select_order_type'          => 'Sélectionnez le type de commande',
    'select_order_type_first'    => 'Sélectionnez d\'abord le type de commande',
    'delivery'                   => 'Livraison',
    'pick_up'                    => 'Retrait',
    'pre_ordered_products'       => 'Produits précommandés',
    'quantity'                   => 'Quantité',
    'order_type'                 => 'Type de commande',
    'requested_at'               => 'Demandé à',
    'view_supplier_response'     => 'Voir la réponse du fournisseur',
    'supplier_response'          => 'Réponse du fournisseur',
    'responded_at'               => 'Répondu à :',
    'order_status'               => 'Statut de la commande -',
    'available_quantity'         => 'Quantité disponible -',
    'price'                      => 'Prix',
    'update_order'               => 'Mettre à jour la commande',
    'product_price'              => 'Prix du produit',
    'price_required'             => 'Le prix est requis',
    'available_product_quantity' => 'Quantité de produit disponible',
    'remarks'                    => 'Remarques',
    'remark_required'            => 'La remarque est requise',
    'select_status_first'        => 'Sélectionnez d\'abord le statut',
    'add_more_suppliers'         => 'Ajouter plus de fournisseurs',
    'load_more'                  => 'Charger plus',
        'continue_guest'                  => 'Continuer en tant qu’invité',
                'price_comparison_chart' => 'Tableau de comparaison des prix',
        'show_all'               => 'Tout afficher',
        'view_pre_orders'        => 'Voir les précommandes',
        'choose_product'         => 'Choisir un produit',
        'category_price_trend'   => 'Tendance des prix de {category_name}',
        'view_price_trends'      => 'Voir les tendances des prix',





            ],
        ]
    ];

    // Select translations based on language_id
    $selectedTranslations = match ($language_id) {
        2 => $translations['fr'],
        default => $translations['en'],
    };

    return response()->json([
        'status' => true,
        'language_id' => $language_id,
        'message' => 'Translations fetched successfully',
        'data' => $selectedTranslations
    ], 200);
}





    public function getRegistrationFormStructure(Request $request)
{
    // Query se language_id le lo (default = 1)
    $language_id = $request->query('language_id', 1);

    // Define both language structures
    $formStructure = [
        'en' => [
            'username'     => 'Username',
            'name'         => 'Full Name',
            'email'        => 'Email Address',
            'phone'        => 'Phone Number',
            'password'     => 'Password',
            'usertype_id'  => 'User Type',
            'country_id'   => 'Country',
            'language_id'  => 'Language',
            'image'        => 'Profile Image',
          
        ],
        'fr' => [
            'username'     => 'Nom d’utilisateur',
            'name'         => 'Nom complet',
            'email'        => 'Adresse e-mail',
            'phone'        => 'Numéro de téléphone',
            'password'     => 'Mot de passe',
            'usertype_id'  => 'Type d’utilisateur',
            'country_id'   => 'Pays',
            'language_id'  => 'Langue',
            'image'        => 'Image de profil',
          
        ],
    ];

    // Language select karo id ke base pe
    $selectedForm = match ((int)$language_id) {
        2 => $formStructure['fr'],
        default => $formStructure['en'],
    };

    return response()->json([
        'status' => true,
        'language_id' => (int)$language_id,
        'message' => 'Registration form structure fetched successfully',
        'data' => $selectedForm
    ], 200);
}




 
public function store(Request $request)
{
    $isUpdate = $request->has('id');

    $rules = [
        //'username'    => ['required', Rule::unique('users', 'username')->ignore($request->id)], // ✅ remove username validation
        'name'        => 'required|string',
        'email'       => ['required', 'email', Rule::unique('users', 'email')->ignore($request->id)],
        'phone'       => ['required', 'string', Rule::unique('users', 'phone')->ignore($request->id)],
        'password'    => $isUpdate ? 'nullable|min:6' : 'required|min:6',
        'usertype_id' => 'required|exists:usertype,id',
        'country_id'  => 'required|exists:countries,id',
        'language_id' => 'nullable|exists:languages,id',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'device_id'   => 'nullable|string'
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
    }

    $language = $request->language_id
        ? Language::find($request->language_id)
        : Language::where('lang_code', 'en')->first();

    $tr = new GoogleTranslate($language->lang_code ?? 'en');

    DB::beginTransaction();
    try {

        /** ---------- IMAGE UPLOAD ---------- **/
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '_' . $imageFile->getClientOriginalName();
            $imageFile->move(public_path('uploads/user_images'), $imageName);
        }

        /** ---------- OTP GENERATE ---------- **/
        $otp = rand(100000, 999999);
        $otpExpiry = now()->addMinutes(10);

        /** ---------- COMMON DATA ---------- **/
        $data = [
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'country_id'     => $request->country_id,
            'language_id'    => $language->id ?? null,
            'image'          => $imageName,
            'otp'            => $otp,
            'otp_expires_at' => $otpExpiry,
            'device_id'      => $request->device_id ?? Str::uuid(),
            'city'           => $request->city,
            'region'         => $request->region,
            'address'        => $request->address,
            'state_entity_registration'     => $request->state_entity_registration,
            'employer_identification_number'=> $request->employer_identification_number,
            'latitude'       => $request->latitude,
            'longitude'      => $request->longitude,
            'altitude'       => $request->altitude,
            'accuracy'       => $request->accuracy,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        /** =========================================================
         *                USERTYPE 1 → AGENTS TABLE
         * ========================================================= **/
        if ($request->usertype_id == 1) {
            $data['usertype_id'] = 1;
            $data['status_id']   = 1;

            $user = \App\Models\Agent::updateOrCreate(
                ['id' => $request->id ?? null],
                $data
            );

            $notificationType = "agent";
        }

        /** =========================================================
         *                USERTYPE 2 → SUPPLIERS TABLE
         * ========================================================= **/
        elseif ($request->usertype_id == 2) {

            if ($isUpdate) {
                unset($data['usertype_id']);
            } else {
                $data['password']    = Hash::make($request->password);
                $data['usertype_id'] = 2;
            }

            $data['status_id'] = 1;
            $data['company_name'] = $request->company_name ?? $request->name;
            $data['manager_name'] = $request->manager_name ?? $request->name;
            $data['position']     = $request->position ?? 'Manager';

            $user = \App\Models\Supplier::updateOrCreate(
                ['id' => $request->id ?? null],
                $data
            );

            $notificationType = "supplier";
        }

        /** =========================================================
         *                USERTYPE 3 → USERS TABLE
         * ========================================================= **/
        elseif ($request->usertype_id == 3) {
            $data['usertype_id'] = 3;

            $user = \App\Models\User::updateOrCreate(
                ['id' => $request->id ?? null],
                $data
            );

            $notificationType = "user";
        }

        /** ---------- SEND OTP EMAIL ---------- **/
        if (!empty($user->email)) {
            try {
                Mail::raw("Your OTP for registration is: $otp", function ($message) use ($user) {
                    $message->to($user->email)->subject('Email Verification OTP');
                });
            } catch (\Exception $mailEx) {
                Log::warning("Email sending failed: " . $mailEx->getMessage());
            }
        }

        DB::commit();

        // ✅ Hide OTP fields in response
        $userData = $user->makeHidden(['otp', 'otp_expires_at']);

      return response()->json([
    'status'  => true,
    'message' => $tr->translate($isUpdate ? 'Updated successfully' : 'Created successfully'),
    'notification_type' => $notificationType,
    'data' => $userData,
], $isUpdate ? 200 : 201);


    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status'  => false,
            'message' => 'Operation failed',
            'error'   => $e->getMessage()
        ], 500);
    }
}





public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email'       => 'required|email',
        'password'    => 'required|min:6',
        'usertype_id' => 'required|exists:usertype,id',
        'device_id'   => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $usertype = $request->usertype_id;

    switch ($usertype) {
        case 1: $userModel = \App\Models\Agent::class; break;
        case 2: $userModel = \App\Models\Supplier::class; break;
        case 3: $userModel = \App\Models\User::class; break;
        default:
            return response()->json([
                'status' => false,
                'message' => 'Invalid user type'
            ], 401);
    }

    // FIND USER
    $user = $userModel::where('email', $request->email)
                      ->where('usertype_id', $usertype)
                      ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid email, password or user type'
        ], 401);
    }

    /* -------------------------------------------------
     | 🔥 If Not Verified → Send OTP but DO NOT CHANGE RESPONSE
     ------------------------------------------------- */
    if ($user->verify !== 'yes') {

        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        try {
            Mail::raw("Your OTP for verification is: $otp", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Email Verification OTP');
            });
        } catch (\Exception $ex) {
            \Log::warning("OTP email failed: " . $ex->getMessage());
        }
    }

    /* -------------------------------------------------
     | 👍 Normal Login Response (Same as Verified User)
     ------------------------------------------------- */

    // Save device id
    $user->device_id = $request->device_id ?? $user->device_id ?? Str::uuid();
    $user->save();

    // Language translate
    $langCode = $user->language_id 
        ? optional(Language::find($user->language_id))->lang_code 
        : 'en';

    $tr = new GoogleTranslate($langCode);

    // Prepare Response Data
    $userData = $user->toArray();

    unset($userData['otp']); // remove otp from response

    // Add otp_verified flag
    $userData['otp_verified'] = ($user->verify === 'yes');
    $userData['country_id']   = $user->country_id ?? null;

    $userData['name'] = $user->name
        ?? $user->manager_name
        ?? $user->company_name
        ?? 'No Name';

    $userData['image'] = isset($user->image)
        ? url('/uploads/user_images/' . $user->image)
        : null;

    $userData['device_id'] = $user->device_id;

    // FINAL RESPONSE (SAME ALWAYS)
    return response()->json([
        'status'  => true,
        'message' => $tr->translate('Login successful'),
        'data'    => $userData
    ], 200);
}




    // ======= FORGOT PASSWORD (EMAIL ONLY) =======
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'errors'=>$validator->errors()],422);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status'=>false,'message'=>'User not found'],404);
        }

        $langCode = $user->language ? $user->language->lang_code : 'en';
        $tr = new GoogleTranslate($langCode);

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        // Send OTP email in user's language
        Mail::raw($tr->translate("Your OTP for password reset is: $otp"), function($message) use ($user,$tr) {
            $message->to($user->email)
                    ->subject($tr->translate('Password Reset OTP'));
        });

        return response()->json([
            'status'=>true,
            'message'=>$tr->translate('OTP sent to your email. Valid for 10 minutes.')
        ],200);
    }

public function verifyRegistrationOtp(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'usertype_id' => 'required|exists:usertype,id',
        'otp' => 'required|digits:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
    }

    $usertype = $request->usertype_id;

    // Get user
    if ($usertype == 1) {
        $user = \App\Models\Agent::where('email', $request->email)->first();
    } elseif ($usertype == 2) {
        $user = \App\Models\Supplier::where('email', $request->email)->first();
    } else {
        $user = \App\Models\User::where('email', $request->email)->first();
    }

    if (!$user) {
        return response()->json(['status' => false, 'message' => 'User not found'], 404);
    }

    // ❌ OTP match check
    if ($user->otp !== $request->otp) {
        return response()->json(['status' => false, 'message' => 'Invalid OTP'], 400);
    }

    // ❌ OTP expiry check
    if ($user->otp_expires_at < Carbon::now()) {
        return response()->json(['status' => false, 'message' => 'OTP expired'], 400);
    }

    // 🔥 OTP VERIFIED → UPDATE verify COLUMN
    $user->verify = 'yes';
    $user->otp = null;
    $user->otp_expires_at = null;
    $user->save();

    // Hide otp fields
    $userData = $user->makeHidden(['otp', 'otp_expires_at']);

    return response()->json([
        'status' => true,
        'message' => 'OTP verified successfully',
        'data' => $userData,
        'usertype_id' => $usertype
    ], 200);
}



    // ======= RESET PASSWORD =======
    public function resetPasswordWithOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'otp'=>'required|digits:6',
            'password'=>'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'errors'=>$validator->errors()],422);
        }

        $user = User::where('email',$request->email)
                    ->where('otp',$request->otp)
                    ->first();

        $langCode = $user && $user->language ? $user->language->lang_code : 'en';
        $tr = new GoogleTranslate($langCode);

        if (!$user || $user->otp_expires_at < now()) {
            return response()->json(['status'=>false,'message'=>$tr->translate('Invalid or expired OTP')],400);
        }

        $user->password = $request->password; // hashed via User model
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return response()->json(['status'=>true,'message'=>$tr->translate('Password reset successfully')],200);
    }

    

public function changeLanguage(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
        'language_id' => 'required|exists:languages,id'
    ]);

    $id = $request->id;
    $language_id = $request->language_id;

    $entity = null;
    $type = null;

    // Check in Users table
    $entity = \App\Models\User::find($id);
    if ($entity) {
        $type = 'user';
    } 

    // Check in Agents table if not found in Users
    if (!$entity) {
        $entity = \App\Models\Agent::find($id);
        if ($entity) $type = 'agent';
    }

    // Check in Suppliers table if not found yet
    if (!$entity) {
        $entity = \App\Models\Supplier::find($id);
        if ($entity) $type = 'supplier';
    }

    // If not found in any table
    if (!$entity) {
        return response()->json(['status' => false, 'message' => 'ID not found in any table']);
    }

    // Update language
    $entity->language_id = $language_id;
    $entity->save();

    // Get selected language
    $language = \App\Models\Language::find($language_id);
    $langCode = $language ? $language->lang_code : 'en';

    // Translate message
    $tr = new \Stichoza\GoogleTranslate\GoogleTranslate($langCode);
    $msg = $tr->translate('Language changed successfully');

    return response()->json([
        'status' => true,
        'message' => $msg,
        'type' => $type,
        'data' => $entity,
        'selected_language' => $language
    ]);
}


public function getLanguages($id = null)
{
    if ($id) {
        $language = \DB::table('languages')->where('id', $id)->first();

        if (!$language) {
            return response()->json([
                'success' => false,
                'message' => 'Language not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $language
        ]);
    }

    // If no ID, return all
    $languages = \DB::table('languages')->get();

    return response()->json([
        'success' => true,
        'count' => $languages->count(),
        'data' => $languages
    ]);
}






}


