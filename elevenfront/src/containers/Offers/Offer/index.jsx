import React from 'react';
import PropTypes from 'prop-types';

// Et pour finir, on cree grace au infomations recus chaque offres.

class Offer extends React.Component {

    constructor() {
        super();
    }

    render() {
// Ici, on etablit le format dans lequelle on veut voir nos offres.
        return (
            <div>
                <h1>{this.props.offer.title}</h1>
                <h3>{this.props.offer.description}</h3>
                <h3>{this.props.offer.price}</h3>
                <a href={'/offers/' + this.props.offer.id}>offers{this.props.offer.id}</a>
            </div>
        );
    }
}

Offer.propTypes = {
    offer: PropTypes.object
};

export default Offer;
