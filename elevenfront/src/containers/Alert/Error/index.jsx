import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { Alert } from 'react-bootstrap';

class Error extends Component {

    render () {

        

        return (
            
            <div>
                {this.props.messages.map((message, key) => 
                    <Alert bsStyle="danger" key={key}> {message} </Alert>
                )}             
            </div>
            
        );

    }

}

Error.propTypes = {
    messages: PropTypes.array
};

export default Error;