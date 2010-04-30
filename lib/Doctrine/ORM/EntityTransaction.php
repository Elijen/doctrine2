<?php
/*
 *  $Id$
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM;

use Doctrine\DBAL\Transaction;

/**
 * The Transaction class is the central access point to ORM Transaction functionality.
 * This class acts more as a delegate class to the DBAL Transaction functionality.
 *
 * @license http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link    www.doctrine-project.org
 * @since   2.0
 * @version $Revision$
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 */
class EntityTransaction
{
    /**
     * The wrapped DBAL Transaction.
     *
     * @var Doctrine\DBAL\Transaction
     */
    protected $_wrappedTransaction;

    /**
     * Constructor.
     *
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->_wrappedTransaction = $transaction;
    }

    /**
     * Checks whether a transaction is currently active.
     *
     * @return boolean TRUE if a transaction is currently active, FALSE otherwise.
     */
    public function isTransactionActive()
    {
        return $this->_wrappedTransaction->isTransactionActive();
    }

    /**
     * Sets the transaction isolation level.
     *
     * @param integer $level The level to set.
     */
    public function setTransactionIsolation($level)
    {
        return $this->_wrappedTransaction->setTransactionIsolation($level);
    }

    /**
     * Gets the currently active transaction isolation level.
     *
     * @return integer The current transaction isolation level.
     */
    public function getTransactionIsolation()
    {
        return $this->_wrappedTransaction->getTransactionIsolation();
    }

    /**
     * Returns the current transaction nesting level.
     *
     * @return integer The nesting level. A value of 0 means there's no active transaction.
     */
    public function getTransactionNestingLevel()
    {
        return $this->_wrappedTransaction->getTransactionNestingLevel();
    }

    /**
     * Starts a transaction by suspending auto-commit mode.
     *
     * @return void
     */
    public function begin()
    {
        $this->_wrappedTransaction->begin();
    }

    /**
     * Commits the current transaction.
     *
     * @return void
     * @throws Doctrine\DBAL\ConnectionException If the commit failed due to no active transaction or
     *                                           because the transaction was marked for rollback only.
     */
    public function commit()
    {
        $this->_wrappedTransaction->commit();
    }

    /**
     * Cancel any database changes done during the current transaction.
     *
     * this method can be listened with onPreTransactionRollback and onTransactionRollback
     * eventlistener methods
     *
     * @throws Doctrine\DBAL\ConnectionException If the rollback operation failed.
     */
    public function rollback()
    {
        $this->_wrappedTransaction->rollback();
    }

    /**
     * Marks the current transaction so that the only possible
     * outcome for the transaction to be rolled back.
     *
     * @throws ConnectionException If no transaction is active.
     */
    public function setRollbackOnly()
    {
        $this->_wrappedTransaction->setRollbackOnly();
    }

    /**
     * Check whether the current transaction is marked for rollback only.
     *
     * @return boolean
     * @throws ConnectionException If no transaction is active.
     */
    public function getRollbackOnly()
    {
        return $this->_wrappedTransaction->getRollbackOnly();
    }
}