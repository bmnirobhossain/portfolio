/**
 * External dependencies
 */
import classnames from 'classnames/dedupe';

/**
 * Internal dependencies
 */
import FieldLabel from '../../field-label';
import FieldDescription from '../../field-description';
import { getFieldAttributes, FieldDefaultSettings } from '../../field-attributes';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;

const { applyFilters } = wp.hooks;

const { Component, Fragment } = wp.element;

const { PanelBody, TextControl, SelectControl } = wp.components;

const { InspectorControls, RichText } = wp.blockEditor;

/**
 * Block Edit Class.
 */
class BlockEdit extends Component {
  render() {
    const { attributes, setAttributes } = this.props;

    const {
      description,
      nameFields,
      descriptionLast,
      placeholderLast,
      defaultLast,
      descriptionMiddle,
      placeholderMiddle,
      defaultMiddle,
    } = attributes;

    let { className = '' } = this.props;

    className = classnames(
      'ghostkit-form-field ghostkit-form-field-name',
      nameFields === 'first-middle-last' || nameFields === 'first-last'
        ? 'ghostkit-form-field-name-with-last'
        : '',
      nameFields === 'first-middle-last' ? 'ghostkit-form-field-name-with-middle' : '',
      className
    );

    className = applyFilters('ghostkit.editor.className', className, this.props);

    return (
      <Fragment>
        <InspectorControls>
          <PanelBody>
            <FieldDefaultSettings {...this.props} />
          </PanelBody>
          <PanelBody title={__('Name Fields', 'ghostkit')}>
            <SelectControl
              options={[
                {
                  label: 'First',
                  value: 'first',
                },
                {
                  label: 'First Last',
                  value: 'first-last',
                },
                {
                  label: 'First Middle Last',
                  value: 'first-middle-last',
                },
              ]}
              value={nameFields}
              onChange={(val) => {
                if (val === 'first-last') {
                  setAttributes({
                    nameFields: val,
                    description: description || __('First', 'ghostkit'),
                    descriptionLast: descriptionLast || __('Last', 'ghostkit'),
                  });
                } else if (val === 'first-middle-last') {
                  setAttributes({
                    nameFields: val,
                    description: description || __('First', 'ghostkit'),
                    descriptionLast: descriptionLast || __('Last', 'ghostkit'),
                    descriptionMiddle: descriptionMiddle || __('Middle', 'ghostkit'),
                  });
                } else {
                  setAttributes({ nameFields: val });
                }
              }}
            />
            {nameFields === 'first-middle-last' ? (
              <Fragment>
                <TextControl
                  label={__('Middle Placeholder', 'ghostkit')}
                  value={placeholderMiddle}
                  onChange={(val) => setAttributes({ placeholderMiddle: val })}
                />
                <TextControl
                  label={__('Middle Default', 'ghostkit')}
                  value={defaultMiddle}
                  onChange={(val) => setAttributes({ defaultMiddle: val })}
                />
              </Fragment>
            ) : (
              ''
            )}
            {nameFields === 'first-middle-last' || nameFields === 'first-last' ? (
              <Fragment>
                <TextControl
                  label={__('Last Placeholder', 'ghostkit')}
                  value={placeholderLast}
                  onChange={(val) => setAttributes({ placeholderLast: val })}
                />
                <TextControl
                  label={__('Last Default', 'ghostkit')}
                  value={defaultLast}
                  onChange={(val) => setAttributes({ defaultLast: val })}
                />
              </Fragment>
            ) : (
              ''
            )}
          </PanelBody>
        </InspectorControls>
        <div className={className}>
          <FieldLabel {...this.props} />

          {nameFields === 'first-middle-last' || nameFields === 'first-last' ? (
            <div className="ghostkit-form-field-row">
              <div className="ghostkit-form-field-name-first">
                <TextControl type="email" {...getFieldAttributes(attributes)} />
                <FieldDescription {...this.props} />
              </div>
              {nameFields === 'first-middle-last' ? (
                <div className="ghostkit-form-field-name-middle">
                  <TextControl
                    type="email"
                    {...getFieldAttributes({
                      slug: attributes.slug ? `${attributes.slug}-middle` : null,
                      placeholder: attributes.placeholderMiddle,
                      default: attributes.defaultMiddle,
                      required: attributes.required,
                    })}
                  />
                  <RichText
                    tagName="small"
                    className="ghostkit-form-field-description"
                    value={descriptionMiddle}
                    placeholder={__('Write description…', 'ghostkit')}
                    onChange={(val) => setAttributes({ descriptionMiddle: val })}
                  />
                </div>
              ) : (
                ''
              )}
              {nameFields === 'first-middle-last' || nameFields === 'first-last' ? (
                <div className="ghostkit-form-field-name-last">
                  <TextControl
                    type="email"
                    {...getFieldAttributes({
                      slug: attributes.slug ? `${attributes.slug}-last` : null,
                      placeholder: attributes.placeholderLast,
                      default: attributes.defaultLast,
                      required: attributes.required,
                    })}
                  />
                  <RichText
                    tagName="small"
                    className="ghostkit-form-field-description"
                    value={descriptionLast}
                    placeholder={__('Write description…', 'ghostkit')}
                    onChange={(val) => setAttributes({ descriptionLast: val })}
                  />
                </div>
              ) : (
                ''
              )}
            </div>
          ) : (
            <Fragment>
              <TextControl type="email" {...getFieldAttributes(attributes)} />
              <FieldDescription {...this.props} />
            </Fragment>
          )}
        </div>
      </Fragment>
    );
  }
}

export default BlockEdit;
