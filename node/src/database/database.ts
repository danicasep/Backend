import mysql from 'mysql2/promise';
require('dotenv').config()
export class Database {
  private config = {
        host: process.env.DB_HOST || 'localhost',
        user: process.env.DB_USERNAME || 'root',
        password: process.env.DB_PASSWORD || 'your_password',
        database: process.env.DB_DATABASE || 'your_database',
        waitForConnections: true,
        connectionLimit: 10,
        queueLimit: 0
    };
  private pool = mysql.createPool(this.config);

  constructor() {
    console.log(this.config)
  }
  public async select(query: string, params: any[] = []): Promise<any[]> {
    const [rows] = await this.pool.execute(query, params);
    return rows as any[];
  }

  public async updateCctvStatus(id:any, status: boolean): Promise<void> {
    const query = 'UPDATE cctv SET cctvStatus = ? WHERE id = ?';
    await this.pool.execute(query, [status ? 1 : 0, id]);
  }
}
