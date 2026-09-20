import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import './editor.scss';
import './style.scss';

registerBlockType('pizza-menu/pizzas', {
    
    edit() {
        const blockProps = useBlockProps({
            className: 'pizza-menu-editor-placeholder',
        });

        return (
            <div {...blockProps}>
                <strong>Liste des pizzas</strong>
                <p>Les pizzas seront affichées ici.</p>
            </div>
        );
    },

    save() {
        return null; // Le rendu sera géré par PHP cela permet un affichage dynamique.
    }
});