import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { Alert } from 'react-bootstrap';

class Success extends Component {

    render () {

        return (
            
            <div>
                {this.props.messages.map((message, key) => 
                    <Alert bsStyle="success" key={key}> {message} </Alert>
                )}                 
            </div>
            
        );

    }

}

Success.propTypes = {
    messages: PropTypes.array
};

export default Success;