/**
 * External dependencies
 */
import get from 'lodash/get';
import isUndefined from 'lodash/isUndefined'; 
import pickBy from 'lodash/pickBy';
import classnames from 'classnames';

const { Component, Fragment } = wp.element;

const { __ } = wp.i18n;

const { decodeEntities } = wp.htmlEntities;

const {
	registerStore,
	withSelect,
} = wp.data;

const {
	PanelBody,
	Placeholder,
	QueryControls,
	RangeControl,
	SelectControl,
	Spinner,
	TextControl,
	ToggleControl,
	Toolbar,
	withAPIData
} = wp.components;

const {
	InspectorControls,
	BlockControls,
} = wp.editor;

const {
	BlockAlignmentToolbar,
	ServerSideRender
} = wp.blockEditor;

const MAX_POSTS_COLUMNS = 4;

class MasterAccordion extends Component {
	constructor() {
		super( ...arguments );
	}

	render() {
		const { attributes, faqCatList, tagsList, setAttributes, jltmafPosts } = this.props;
		const { 
				align,
				order, 
				orderBy,
				faqCat, 
				faqTags, 
				postsToShow
			} = attributes;

		const inspectorControls = (
			<InspectorControls>
				<PanelBody title={ __( 'Master FAQ Settings' ) }>
					
					<QueryControls
						{ ...{ order, orderBy } }
						numberOfItems={ postsToShow }
						categoriesList={ faqCatList }
						selectedCategoryId={ faqCat }
						onCategoryChange={ ( value ) => setAttributes( { faqCat: '' !== value ? value : undefined } ) }

						tagsList={ tagsList }
						onOrderChange={ ( value ) => setAttributes( { order: value } ) }
						onOrderByChange={ ( value ) => setAttributes( { orderBy: value } ) }
						onNumberOfItemsChange={ ( value ) => setAttributes( { postsToShow: value } ) }
					/>


				</PanelBody>
			</InspectorControls>
		);


		return (
			<Fragment>
				{ inspectorControls }
				<BlockControls>
					<BlockAlignmentToolbar
						value={ align }
						onChange={ ( value ) => {
							setAttributes( { align: value } );
						} }
						controls={ [ 'center', 'wide', 'full' ] }
					/>
				</BlockControls>
				<ServerSideRender
					block = "jltmaf/master-accordion"
					attributes = { attributes }
				/>
				
			</Fragment>
		);
	}
}

export default withSelect( ( select, props ) => {
	const { postsToShow, order, orderBy, faqCat, faqTags } = props.attributes;
	const { getEntityRecords } = select( 'core' );
	const jltmafPostsQuery = pickBy( {
		faqCat,
		faqTags,
		order,
		orderby: orderBy,
		per_page: postsToShow,
	}, ( value ) => ! isUndefined( value ) );
	const faqCatListQuery = {
		per_page: 100,
	};	
	const tagsListQuery = {
		per_page: 100,
	};
	return {
		jltmafPosts: getEntityRecords( 'postType', 'faq', jltmafPostsQuery ),
		faqCatList: getEntityRecords( 'taxonomy', 'faq_cat', faqCatListQuery ),
		// faqCatList: wp.data.select('core').getEntityRecords('taxonomy', 'faq_cat', {per_page: 100}),
		tagsList: getEntityRecords( 'taxonomy', 'faqTags', tagsListQuery ),
	};
} )( MasterAccordion );